<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Spatial extends BaseController
{
    use ResponseTrait;

    public function check()
    {
        $lat = $this->request->getVar('lat');
        $lng = $this->request->getVar('lng');

        if (!$lat || !$lng) {
            return $this->fail('Coordinates (lat, lng) are required.', 400);
        }

        $rdtrModel = new \App\Models\RdtrModel();
        $rtrwModel = new \App\Models\RtrwModel();
        $auditModel = new \App\Models\AuditLogModel();

        // Perform Spatial Checks
        // Note: PostGIS query should handle SRID 4326
        $rdtrResult = $rdtrModel->checkLocation($lat, $lng);
        $rtrwResult = $rtrwModel->checkLocation($lat, $lng);

        // Prepare Response
        $data = [
            'coordinates' => ['lat' => $lat, 'lng' => $lng],
            'rdtr' => null,
            'rtrw' => $rtrwResult ? [
                'nama_kawasan' => $rtrwResult['nama_kawasan'],
                'fungsi_kawasan' => $rtrwResult['fungsi_kawasan'],
                'color' => $rtrwResult['color']
            ] : null,
        ];

        // Enhanced RDTR with ITBX and Activities
        if ($rdtrResult) {
            $activityModel = new \App\Models\ActivityModel();
            $activityCounts = $activityModel->getActivityCountByStatus($rdtrResult['id']);

            $data['rdtr'] = [
                'id' => $rdtrResult['id'],
                'nama_zona' => $rdtrResult['nama_zona'],
                'peruntukan' => $rdtrResult['peruntukan'],
                'keterangan' => $rdtrResult['keterangan'],
                'regulation_text' => $rdtrResult['regulation_text'],
                'color' => $rdtrResult['color'],
                'itbx' => [
                    'kdb' => $rdtrResult['kdb'] ?? null,
                    'klb' => $rdtrResult['klb'] ?? null,
                    'kdh' => $rdtrResult['kdh'] ?? null,
                    'ktb' => $rdtrResult['ktb'] ?? null,
                    'ketinggian_max' => $rdtrResult['ketinggian_max'] ?? null,
                    'jumlah_lantai_max' => $rdtrResult['jumlah_lantai_max'] ?? null,
                    'gsb' => $rdtrResult['gsb'] ?? null,
                    'gsl' => $rdtrResult['gsl'] ?? null,
                ],
                'activity_counts' => $activityCounts,
                'sub_zona' => $rdtrResult['sub_zona'] ?? null,
                'arahan_pemanfaatan' => $rdtrResult['arahan_pemanfaatan'] ?? null,
            ];
        }

        // Logging
        $logData = [
            'user_id' => session()->get('id') ?? null, // Nullable if public
            'search_lat' => $lat,
            'search_lng' => $lng,
            'search_time' => date('Y-m-d H:i:s'),
            'result_summary' => json_encode([
                'rdtr_found' => !empty($rdtrResult),
                'rtrw_found' => !empty($rtrwResult),
                'rdtr_zona' => $rdtrResult['nama_zona'] ?? null
            ]),
        ];
        $auditModel->insert((object)$logData);

        return $this->respond([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ]);
    }
    public function layers()
    {
        $rdtrModel = new \App\Models\RdtrModel();
        $rtrwModel = new \App\Models\RtrwModel();

        // Fetch All Data with GeoJSON
        $rdtrData = $rdtrModel->getAllWithGeoJSON();
        $rtrwData = $rtrwModel->getAllWithGeoJSON();

        // Convert to Standard GeoJSON FeatureCollection
        $rdtrFeatures = [];
        foreach ($rdtrData as $row) {
            $rdtrFeatures[] = [
                'type' => 'Feature',
                'properties' => [
                    'nama_zona' => $row['nama_zona'],
                    'peruntukan' => $row['peruntukan'],
                    'color' => $row['color'],
                    'itbx' => [
                        'kdb' => $row['kdb'],
                        'klb' => $row['klb'],
                        'kdh' => $row['kdh'],
                        'ktb' => $row['ktb'],
                        'ketinggian_max' => $row['ketinggian_max'],
                        'jumlah_lantai_max' => $row['jumlah_lantai_max'],
                        'gsb' => $row['gsb'],
                        'gsl' => $row['gsl']
                    ]
                ],
                'geometry' => json_decode($row['geojson'])
            ];
        }

        $rtrwFeatures = [];
        foreach ($rtrwData as $row) {
            $rtrwFeatures[] = [
                'type' => 'Feature',
                'properties' => [
                    'nama_kawasan' => $row['nama_kawasan'],
                    'fungsi_kawasan' => $row['fungsi_kawasan'],
                    'color' => $row['color']
                ],
                'geometry' => json_decode($row['geojson'])
            ];
        }

        return $this->respond([
            'status' => true,
            'data' => [
                'rdtr' => [
                    'type' => 'FeatureCollection',
                    'features' => $rdtrFeatures
                ],
                'rtrw' => [
                    'type' => 'FeatureCollection',
                    'features' => $rtrwFeatures
                ]
            ]
        ]);
    }

    /**
     * Validate KBLI code against zone restrictions
     * POST /api/spatial/validate-kbli
     * Body: {lat, lng, kbli_code}
     */
    public function validateKBLI()
    {
        $lat = $this->request->getPost('lat');
        $lng = $this->request->getPost('lng');
        $kbliCode = $this->request->getPost('kbli_code');

        if (!$lat || !$lng || !$kbliCode) {
            return $this->fail('Missing required parameters: lat, lng, kbli_code');
        }

        // Get RDTR zone
        $rdtrModel = new \App\Models\RdtrModel();
        $rdtrResult = $rdtrModel->checkLocation($lat, $lng);

        if (!$rdtrResult) {
            return $this->respond([
                'status' => false,
                'message' => 'Lokasi tidak berada dalam zona RDTR manapun',
                'data' => null
            ]);
        }

        // Validate KBLI
        helper('kbli');
        $validation = \App\Helpers\KBLIHelper::validateKBLI($kbliCode, $rdtrResult['kbli_allowed']);
        $kbliName = \App\Helpers\KBLIHelper::getKBLIName($kbliCode);

        return $this->respond([
            'status' => true,
            'message' => 'success',
            'data' => [
                'zone' => $rdtrResult['nama_zona'],
                'kbli_code' => $kbliCode,
                'kbli_name' => $kbliName,
                'allowed' => $validation['allowed'],
                'validation_message' => $validation['message']
            ]
        ]);
    }
}