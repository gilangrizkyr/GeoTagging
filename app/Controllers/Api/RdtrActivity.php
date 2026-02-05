<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class RdtrActivity extends ResourceController
{
    protected $modelName = 'App\Models\ActivityModel';
    protected $format = 'json';

    /**
     * Get activities for a specific RDTR zone
     * GET /api/rdtr/zone/:zoneId/activities
     */
    public function getByZone($zoneId)
    {
        $activityModel = new \App\Models\ActivityModel();
        $activities = $activityModel->getActivitiesByZone($zoneId);

        return $this->respond([
            'status' => true,
            'message' => 'success',
            'data' => $activities
        ]);
    }
}