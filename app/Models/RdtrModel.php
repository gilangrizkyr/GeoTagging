<?php

namespace App\Models;

use CodeIgniter\Model;

class RdtrModel extends Model
{
    protected $table = 'rdtr_zones';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_zona',
        'peruntukan',
        'keterangan',
        'regulation_text',
        'color',
        'kdb',
        'klb',
        'kdh',
        'ktb',
        'ketinggian_max',
        'jumlah_lantai_max',
        'gsb',
        'gsl',
        'sub_zona',
        'arahan_pemanfaatan',
        'kbli_allowed',
        'sumber_data',
        'tanggal_berlaku',
        'versi_data',
        'keterangan_sumber',
        'created_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Check which zone contains the given point.
     */
    public function checkLocation($lat, $lng)
    {
        // First, check for exact intersection
        $sql = "SELECT *, ST_AsGeoJSON(geom) as geojson 
                FROM {$this->table} 
                WHERE ST_Intersects(geom, ST_SetSRID(ST_Point(?, ?), 4326)) 
                LIMIT 1";

        $query = $this->db->query($sql, [(float) $lng, (float) $lat]);
        $row = $query->getRowArray();

        if ($row) {
            $row['dist_m'] = 0;
            return $row;
        }

        // If not found, check for nearest zone within ~100 meters (0.001 degrees)
        $sql = "SELECT *, ST_AsGeoJSON(geom) as geojson, 
                       ST_Distance(geom, ST_SetSRID(ST_Point(?, ?), 4326)) as dist_deg
                FROM {$this->table} 
                WHERE ST_DWithin(geom, ST_SetSRID(ST_Point(?, ?), 4326), 0.001)
                ORDER BY dist_deg ASC 
                LIMIT 1";

        $query = $this->db->query($sql, [(float) $lng, (float) $lat, (float) $lng, (float) $lat]);
        $row = $query->getRowArray();

        if ($row) {
            // Distance in degrees is not helpful, but it confirms proximity
            return $row;
        }

        return null;
    }

    public function getAllWithGeoJSON()
    {
        $sql = "SELECT id, nama_zona, peruntukan, color, kdb, klb, kdh, ktb, ketinggian_max, jumlah_lantai_max, gsb, gsl, ST_AsGeoJSON(geom) as geojson FROM {$this->table}";
        return $this->db->query($sql)->getResultArray();
    }

    public function insertGeoJSON($data, $geoJSON)
    {
        // $data contains scalar fields, $geoJSON is the geometry string
        // We need to raw insert or update. 
        // Helper to construct query.
        $builder = $this->db->table($this->table);
        $set = $data;
        // set geom using raw sql
        // This won't work easily with standard insert() because geom is expression.
        // We usually use a custom query.

        $fields = array_keys($data);
        $values = array_values($data);

        // Add geom
        $fields[] = 'geom';

        // Prepare placeholders
        $placeholders = array_fill(0, count($values), '?');
        $placeholders[] = "ST_SetSRID(ST_GeomFromGeoJSON(?), 4326)";

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";

        return $this->db->query($sql, array_merge($values, [$geoJSON]));
    }
}