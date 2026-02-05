<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Map extends BaseController
{
    public function index()
    {
        return view('map/index');
    }
}