<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['key', 'value'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get a setting by key.
     */
    public function getValue($key, $default = null)
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $setting['value'] : $default;
    }

    /**
     * Get a setting by key with role-specific override.
     */
    public function getValueWithRole($key, $role, $default = null)
    {
        $roleSetting = $this->where('key', $key . '_' . $role)->first();
        if ($roleSetting && $roleSetting['value'] !== null && $roleSetting['value'] !== '') {
            return $roleSetting['value'];
        }
        return $this->getValue($key, $default);
    }

    /**
     * Update or create a setting.
     */
    public function setValue($key, $value)
    {
        $existing = $this->where('key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], ['value' => $value]);
        }
        else {
            return $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}