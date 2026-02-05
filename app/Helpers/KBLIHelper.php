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
                'message' => 'Zona ini tidak memiliki pembatasan KBLI khusus.'
            ];
        }

        // Parse allowed KBLI codes
        $allowedCodes = array_map('trim', explode(',', $allowedKBLI));

        // Check if the code is in the allowed list
        if (in_array($kbliCode, $allowedCodes)) {
            return [
                'allowed' => true,
                'message' => 'KBLI ' . $kbliCode . ' diizinkan di zona ini.'
            ];
        }

        return [
            'allowed' => false,
            'message' => 'KBLI ' . $kbliCode . ' TIDAK diizinkan di zona ini. KBLI yang diizinkan: ' . $allowedKBLI
        ];
    }

    /**
     * Get KBLI category name (simplified reference)
     * In production, this should query a KBLI reference database
     */
    public static function getKBLIName(string $kbliCode): string
    {
        $kbliReference = [
            '46311' => 'Perdagangan Besar Beras',
            '47711' => 'Perdagangan Eceran Pakaian',
            '56101' => 'Restoran',
            '68100' => 'Real Estat',
            '85101' => 'Pendidikan Anak Usia Dini',
            // Add more as needed
        ];

        return $kbliReference[$kbliCode] ?? 'KBLI ' . $kbliCode;
    }
}