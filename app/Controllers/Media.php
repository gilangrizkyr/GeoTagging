<?php

namespace App\Controllers;

use App\Models\MediaModel;
use CodeIgniter\Controller;

class Media extends Controller
{
    /**
     * Serve a media file by its UUID
     */
    public function serve(string $uuid)
    {
        $model = new MediaModel();
        $media = $model->getByUuid($uuid);

        if (!$media) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        $filePath = $media['file_path'];

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('Physical file not found');
        }

        $file = new \CodeIgniter\Files\File($filePath);
        $mime = $media['file_type'] ?: $file->getMimeType();

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $media['original_name'] . '"')
            ->setBody(file_get_contents($filePath));
    }

    /**
     * Download a media file by its UUID
     */
    public function download(string $uuid)
    {
        $model = new MediaModel();
        $media = $model->getByUuid($uuid);

        if (!$media || !file_exists($media['file_path'])) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->download($media['file_path'], null)->setFileName($media['original_name']);
    }
}
