<?php

namespace App\Helpers;

class KBLIHelper
{
    /**
     * Validate if a KBLI code is allowed in a specific zone
     * 
     * @param string $kbliCode The KBLI code to check (e.g., "46311")
     * @param string|null $allowedKBLI Comma-separated allowed KBLI codes from zone
     * @return array ['allowed' => bool, 'message' => string]
     */
    public static function validateKBLI(string $kbliCode, ?string $allowedKBLI): array
    {
        // If no KBLI restriction, allow all
        if (empty($allowedKBLI)) {
            return [
                'allowed' => true,
                'message' => 'Zona ini terbuka untuk semua jenis kegiatan (TIDAK ada pembatasan KBLI).'
            ];
        }

        // Parse allowed KBLI codes
        $allowedCodes = array_map('trim', explode(',', $allowedKBLI));

        // Check if the code is in the allowed list
        if (in_array($kbliCode, $allowedCodes)) {
            return [
                'allowed' => true,
                'message' => 'Kegiatan dengan kode KBLI ' . $kbliCode . ' SESUAI dengan peruntukan zona ini.'
            ];
        }

        return [
            'allowed' => false,
            'message' => 'Maaf, kegiatan ' . $kbliCode . ' TIDAK diizinkan di zona ini berdasarkan aturan RDTR terbaru.'
        ];
    }

    /**
     * Get KBLI category name from config
     */
    public static function getKBLIName(string $kbliCode): string
    {
        $config = config('KBLI');
        return $config->reference[$kbliCode] ?? 'KBLI ' . $kbliCode;
    }
}