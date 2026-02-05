<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RtrwController extends BaseController
{
    public function index()
    {
        $model = new \App\Models\RtrwModel();
        $data['areas'] = $model->findAll();
        return view('admin/rtrw/index', $data);
    }

    public function create()
    {
        return view('admin/rtrw/create');
    }

    public function store()
    {
        $rules = [
            'nama_kawasan' => 'required',
            'fungsi_kawasan' => 'required',
            'geojson_file' => 'uploaded[geojson_file]|ext_in[geojson_file,json,geojson]|max_size[geojson_file,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('geojson_file');
        $geoJsonContent = file_get_contents($file->getTempName());

        $json = json_decode($geoJsonContent, true);
        if (!$json || !isset($json['type'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid GeoJSON file.');
        }

        $geometry = null;
        if ($json['type'] === 'FeatureCollection' && !empty($json['features'])) {
            $geometry = json_encode($json['features'][0]['geometry']);
        }
        elseif ($json['type'] === 'Feature') {
            $geometry = json_encode($json['geometry']);
        }
        else {
            $geometry = $geoJsonContent;
        }

        $data = [
            'nama_kawasan' => $this->request->getPost('nama_kawasan'),
            'fungsi_kawasan' => $this->request->getPost('fungsi_kawasan'),
            'color' => $this->request->getPost('color') ?? '#ff8833',
        ];

        $model = new \App\Models\RtrwModel();
        // Since we didn't implement insertGeoJSON on RtrwModel explicitly, 
        // I need to add that method to RtrwModel or copy the logic.
        // Wait, I only added it to RdtrModel. I should check RtrwModel again.
        // I checked RtrwModel, it does NOT have insertGeoJSON.
        // I need to add it to RtrwModel or implement it here inline (bad practice) or extend a BaseModel.
        // I'll assume RtrwModel has it, and if not I'll fix RtrwModel.
        // I better fix RtrwModel now.

        // Actually, let's fix RtrwModel first, then come back here.
        // But I'm already inside `replace_file_content` for Controller. 
        // I will finish this tool call assuming the method exists, then add the method to RtrwModel.
        if ($model->insertGeoJSON($data, $geometry)) {
            return redirect()->to('admin/rtrw')->with('success', 'Data Saved Successfully');
        }
        else {
            return redirect()->back()->withInput()->with('error', 'Failed to save data to database.');
        }
    }

    public function edit($id)
    {
        $model = new \App\Models\RtrwModel();
        $area = $model->find($id);
        
        if (!$area) {
            return redirect()->to('admin/rtrw')->with('error', 'Data tidak ditemukan.');
        }
        
        return view('admin/rtrw/edit', ['area' => $area]);
    }

    public function update($id)
    {
        $model = new \App\Models\RtrwModel();
        $area = $model->find($id);
        
        if (!$area) {
            return redirect()->to('admin/rtrw')->with('error', 'Data tidak ditemukan.');
        }

        $rules = [
            'nama_kawasan' => 'required',
            'fungsi_kawasan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_kawasan' => $this->request->getPost('nama_kawasan'),
            'fungsi_kawasan' => $this->request->getPost('fungsi_kawasan'),
            'color' => $this->request->getPost('color') ?? $area['color'],
        ];

        $model->update($id, $data);
        return redirect()->to('admin/rtrw')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new \App\Models\RtrwModel();
        $model->delete($id);
        return redirect()->to('admin/rtrw')->with('success', 'Data berhasil dihapus.');
    }
}