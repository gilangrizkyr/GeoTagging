<?php

namespace App\Models;

use CodeIgniter\Model;

class RtrwModel extends Model
{
    protected $table = 'rtrw_areas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_kawasan', 'fungsi_kawasan', 'color'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Check which area contains the given point.
     */
    public function checkLocation($lat, $lng)
    {
        $sql = "SELECT *, ST_AsGeoJSON(geom) as geojson 
                FROM {$this->table} 
                WHERE ST_Contains(geom, ST_SetSRID(ST_Point(?, ?), 4326)) 
                LIMIT 1";

        $query = $this->db->query($sql, [$lng, $lat]);
        return $query->getRowArray();
    }

    public function getAllWithGeoJSON()
    {
        $sql = "SELECT id, nama_kawasan, fungsi_kawasan, color, ST_AsGeoJSON(geom) as geojson FROM {$this->table}";
        return $this->db->query($sql)->getResultArray();
    }

    public function insertGeoJSON($data, $geoJSON)
    {
        $builder = $this->db->table($this->table);
        $set = $data;

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