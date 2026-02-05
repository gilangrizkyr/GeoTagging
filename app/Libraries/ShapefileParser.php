<?php

namespace App\Libraries;

/**
 * Shapefile Parser Library
 * Converts uploaded Shapefile (.shp + .shx + .dbf) to GeoJSON
 * 
 * This is a simplified implementation that uses ogr2ogr command-line tool
 * For production, ensure ogr2ogr (GDAL) is installed on the server
 */
class ShapefileParser
{
    private $uploadPath;
    private $tempPath;

    public function __construct()
    {
        $this->uploadPath = WRITEPATH . 'uploads/shapefiles/';
        $this->tempPath = WRITEPATH . 'temp/';

        // Create directories if they don't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
        if (!is_dir($this->tempPath)) {
            mkdir($this->tempPath, 0755, true);
        }
    }

    /**
     * Parse uploaded shapefile to GeoJSON
     * 
     * @param array $files Array of uploaded files (shp, shx, dbf, prj optional)
     * @return array|false GeoJSON array or false on failure
     */
    public function parseShapefile(array $files)
    {
        // Validate required files
        $requiredExtensions = ['shp', 'shx', 'dbf'];
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $ext = $file->getExtension();
                $uploadedFiles[$ext] = $file;
            }
        }

        // Check if all required files are present
        foreach ($requiredExtensions as $ext) {
            if (!isset($uploadedFiles[$ext])) {
                log_message('error', 'Missing required shapefile component: .' . $ext);
                return false;
            }
        }

        // Generate unique filename
        $uniqueName = uniqid('shp_', true);
        $basePath = $this->uploadPath . $uniqueName;

        // Move uploaded files
        try {
            foreach ($uploadedFiles as $ext => $file) {
                $file->move($this->uploadPath, $uniqueName . '.' . $ext);
            }
        }
        catch (\Exception $e) {
            log_message('error', 'Failed to move shapefile: ' . $e->getMessage());
            return false;
        }

        // Convert to GeoJSON using ogr2ogr
        $shpPath = $basePath . '.shp';
        $geoJsonPath = $this->tempPath . $uniqueName . '.geojson';

        // Check if ogr2ogr is available
        $ogrCheck = shell_exec('which ogr2ogr 2>&1');
        if (empty($ogrCheck)) {
            log_message('error', 'ogr2ogr not found. Please install GDAL/OGR tools.');
            return false;
        }

        // Execute ogr2ogr conversion
        $command = sprintf(
            'ogr2ogr -f GeoJSON -t_srs EPSG:4326 %s %s 2>&1',
            escapeshellarg($geoJsonPath),
            escapeshellarg($shpPath)
        );

        $output = shell_exec($command);

        // Check if conversion succeeded
        if (!file_exists($geoJsonPath)) {
            log_message('error', 'ogr2ogr conversion failed: ' . $output);
            $this->cleanup($basePath);
            return false;
        }

        // Read GeoJSON
        $geoJson = file_get_contents($geoJsonPath);
        $geoJsonArray = json_decode($geoJson, true);

        // Cleanup temporary files
        $this->cleanup($basePath);
        @unlink($geoJsonPath);

        return $geoJsonArray;
    }

    /**
     * Cleanup uploaded shapefile components
     */
    private function cleanup(string $basePath)
    {
        $extensions = ['shp', 'shx', 'dbf', 'prj', 'cpg'];
        foreach ($extensions as $ext) {
            $file = $basePath . '.' . $ext;
            if (file_exists($file)) {
                @unlink($file);
            }
        }
    }

    /**
     * Check if ogr2ogr is available on the system
     */
    public static function isAvailable(): bool
    {
        $check = shell_exec('which ogr2ogr 2>&1');
        return !empty($check);
    }
}