<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table = 'rdtr_activities';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'rdtr_zone_id',
        'nama_kegiatan',
        'kategori_kegiatan',
        'status',
        'syarat',
        'keterangan'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'rdtr_zone_id' => 'required|integer',
        'nama_kegiatan' => 'required|max_length[255]',
        'status' => 'required|in_list[I,T,B,X]',
    ];

    protected $validationMessages = [
        'status' => [
            'in_list' => 'Status harus I (Diizinkan), T (Terbatas), B (Bersyarat), atau X (Dilarang)'
        ]
    ];

    /**
     * Get activities by zone ID grouped by status
     */
    public function getActivitiesByZone($zoneId)
    {
        $activities = $this->where('rdtr_zone_id', $zoneId)->findAll();

        $grouped = [
            'diizinkan' => [],
            'terbatas' => [],
            'bersyarat' => [],
            'dilarang' => []
        ];

        foreach ($activities as $activity) {
            switch ($activity['status']) {
                case 'I':
                    $grouped['diizinkan'][] = $activity;
                    break;
                case 'T':
                    $grouped['terbatas'][] = $activity;
                    break;
                case 'B':
                    $grouped['bersyarat'][] = $activity;
                    break;
                case 'X':
                    $grouped['dilarang'][] = $activity;
                    break;
            }
        }

        return $grouped;
    }

    /**
     * Get activity count by status for a zone
     */
    public function getActivityCountByStatus($zoneId)
    {
        return [
            'diizinkan' => $this->where(['rdtr_zone_id' => $zoneId, 'status' => 'I'])->countAllResults(),
            'terbatas' => $this->where(['rdtr_zone_id' => $zoneId, 'status' => 'T'])->countAllResults(),
            'bersyarat' => $this->where(['rdtr_zone_id' => $zoneId, 'status' => 'B'])->countAllResults(),
            'dilarang' => $this->where(['rdtr_zone_id' => $zoneId, 'status' => 'X'])->countAllResults(),
        ];
    }
}