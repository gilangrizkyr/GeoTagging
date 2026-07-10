<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RdtrModel;
use App\Models\RtrwModel;
use App\Models\AuditLogModel;

class Home extends BaseController
{
    public function index()
    {
        $rdtrModel = new RdtrModel();
        $rtrwModel = new RtrwModel();
        $auditModel = new AuditLogModel();

        // Get total counts
        $totalRdtr = $rdtrModel->countAll();
        $totalRtrw = $rtrwModel->countAll();
        $totalSearches = $auditModel->countAll();

        // Get RDTR zones by peruntukan
        $rdtrByPeruntukan = $rdtrModel->select('peruntukan, COUNT(*) as count')
            ->where('peruntukan IS NOT NULL')
            ->groupBy('peruntukan')
            ->orderBy('count', 'DESC')
            ->limit(8)
            ->findAll();

        // Get top peruntukan
        $topPeruntukan = $rdtrModel->select('peruntukan, COUNT(*) as jumlah')
            ->where('peruntukan IS NOT NULL')
            ->groupBy('peruntukan')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->findAll();

        // Average searches per day (last 7 days)
        $searchesLastWeek = $auditModel->where('search_time >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->countAll();
        $avgSearchesPerDay = round($searchesLastWeek / 7, 2);

        $heroModel = new \App\Models\HeroImageModel();
        $heroImages = $heroModel->getSorted();

        $settingsModel = new \App\Models\SettingsModel();
        $heroSlideInterval = $settingsModel->getValue('hero_slide_interval', '5');

        $data = [
            'totalRdtr' => $totalRdtr,
            'totalRtrw' => $totalRtrw,
            'totalSearches' => $totalSearches,
            'rdtrByPeruntukan' => $rdtrByPeruntukan,
            'topPeruntukan' => $topPeruntukan,
            'avgSearchesPerDay' => $avgSearchesPerDay,
            'heroImages' => $heroImages,
            'heroSlideInterval' => (int) $heroSlideInterval * 1000, // Convert to ms
            'settingsModel' => $settingsModel,
        ];

        return view('home/index', $data);
    }
}
