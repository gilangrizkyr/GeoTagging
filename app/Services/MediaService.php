<?php

namespace App\Services;

use App\Models\MediaModel;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use Exception;

class MediaService
{
    protected $model;
    protected $uploadPath;

    public function __construct()
    {
        $this->model = new MediaModel();
        // Use environment variable for upload path
        $this->uploadPath = env('UPLOAD_PATH', WRITEPATH . 'uploads/');

        // Ensure path ends with slash
        $this->uploadPath = rtrim($this->uploadPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Create directory if not exists
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0775, true);
        }
    }

    /**
     * Upload and store file metadata
     * 
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file
     * @param string|null $category
     * @param int|null $userId
     * @return string|false UUID of the uploaded file
     */
    public function upload($file, ?string $category = null, ?int $userId = null)
    {
        if (!$file->isValid()) {
            log_message('error', 'File upload failed: ' . $file->getErrorString());
            return false;
        }

        try {
            // Generate unique name
            $newName = $file->getRandomName();
            $uuid = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            );

            // Move file to external storage
            $file->move($this->uploadPath, $newName);

            // Save metadata
            $data = [
                'uuid' => $uuid,
                'filename' => $newName,
                'original_name' => $file->getClientName(),
                'file_path' => $this->uploadPath . $newName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'category' => $category,
                'created_by' => $userId
            ];

            if ($this->model->insert($data)) {
                return $uuid;
            }

            return false;
        } catch (Exception $e) {
            log_message('error', 'MediaService Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete file and metadata
     */
    public function delete(string $uuid)
    {
        $media = $this->model->getByUuid($uuid);
        if (!$media)
            return false;

        // Remove from physical storage
        if (file_exists($media['file_path'])) {
            unlink($media['file_path']);
        }

        // Remove from DB
        return $this->model->where('uuid', $uuid)->delete();
    }

    /**
     * Get details by UUID
     */
    public function getDetails(string $uuid)
    {
        return $this->model->getByUuid($uuid);
    }
}
