<?php

namespace App\Helpers;

class KBLIHelper
{
    /** @var array|null Cached KBLI data from JSON */
    private static ?array $cache = null;

    /**
     * Load and cache the KBLI data from kbli2025.json.
     */
    private static function loadData(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $jsonPath = FCPATH . 'json/kbli2025.json';

        if (file_exists($jsonPath)) {
            $content = file_get_contents($jsonPath);
            $decoded = json_decode($content, true);
            self::$cache = $decoded['data'] ?? [];
        } else {
            // Fallback: use Config/KBLI.php reference if JSON not found
            self::$cache = config('KBLI')->reference ?? [];
        }

        return self::$cache;
    }

    /**
     * Get KBLI name by code.
     */
    public static function getKBLIName(string $kbliCode): string
    {
        $data = self::loadData();
        return $data[$kbliCode] ?? 'KBLI ' . $kbliCode;
    }

    /**
     * Get all KBLI data as an associative array [code => name].
     */
    public static function getAll(): array
    {
        return self::loadData();
    }

    /**
     * Search KBLI by keyword — returns matching [code => name] pairs.
     */
    public static function search(string $keyword, int $limit = 20): array
    {
        $keyword = strtolower(trim($keyword));
        $data = self::loadData();
        $results = [];

        foreach ($data as $code => $name) {
            if (
                str_contains(strtolower($name), $keyword) ||
                str_contains($code, $keyword)
            ) {
                $results[$code] = $name;
                if (count($results) >= $limit) {
                    break;
                }
            }
        }

        return $results;
    }

    /**
     * Validate if a KBLI code is allowed in a specific zone.
     *
     * @param string      $kbliCode    5-digit KBLI code
     * @param string|null $allowedKBLI Comma-separated allowed codes from zone
     * @return array ['allowed' => bool, 'message' => string]
     */
    public static function validateKBLI(string $kbliCode, ?string $allowedKBLI): array
    {
        // If no restriction defined, all activities are allowed
        if (empty($allowedKBLI)) {
            return [
                'allowed' => true,
                'message' => 'Zona ini terbuka untuk semua jenis kegiatan (tidak ada pembatasan KBLI).'
            ];
        }

        $allowedCodes = array_map('trim', explode(',', $allowedKBLI));

        if (in_array($kbliCode, $allowedCodes)) {
            $name = self::getKBLIName($kbliCode);
            return [
                'allowed' => true,
                'message' => 'Kegiatan "' . $name . '" (KBLI ' . $kbliCode . ') SESUAI dengan peruntukan zona ini.'
            ];
        }

        $name = self::getKBLIName($kbliCode);
        return [
            'allowed' => false,
            'message' => 'Kegiatan "' . $name . '" (KBLI ' . $kbliCode . ') TIDAK diizinkan di zona ini berdasarkan aturan RDTR 2025.'
        ];
    }
}