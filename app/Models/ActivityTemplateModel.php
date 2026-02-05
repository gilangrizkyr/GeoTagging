<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityTemplateModel extends Model
{
    protected $table = 'activity_templates';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_kegiatan',
        'kategori',
        'kbli_code',
        'deskripsi'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null;

    // Validation
    protected $validationRules = [
        'nama_kegiatan' => 'required|max_length[255]',
    ];

    /**
     * Get templates by category
     */
    public function getByCategory($kategori = null)
    {
        if ($kategori) {
            return $this->where('kategori', $kategori)->findAll();
        }
        return $this->findAll();
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        return $this->select('kategori')
            ->distinct()
            ->where('kategori IS NOT NULL')
            ->findAll();
    }

    /**
     * Search templates
     */
    public function search($keyword)
    {
        return $this->like('nama_kegiatan', $keyword)
            ->orLike('deskripsi', $keyword)
            ->findAll();
    }
}