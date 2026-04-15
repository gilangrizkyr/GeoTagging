<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroImageModel extends Model
{
    protected $table = 'hero_images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['image_path', 'sort_order'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getSorted()
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }
}
