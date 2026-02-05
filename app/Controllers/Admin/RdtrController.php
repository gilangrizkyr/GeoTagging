<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;

class RdtrController extends BaseController
{
    public function index()
    {
        $model = new \App\Models\RdtrModel();
        $data['zones'] = $model->findAll();
        return view('admin/rdtr/index', $data);
    }

    public function create()
    {
        return view('admin/rdtr/create');
    }

    public function store()
    {
        // Check if it's GeoJSON or Shapefile upload
        $uploadType = $this->request->getPost('upload_type') ?? 'geojson';

        $rules = [
            'nama_zona' => 'required',
            'peruntukan' => 'required',
        ];

        if ($uploadType === 'geojson') {
            $rules['geojson_file'] = 'uploaded[geojson_file]|ext_in[geojson_file,json,geojson]|max_size[geojson_file,5120]';
        }
        elseif ($uploadType === 'shapefile') {
            $rules['shp_file'] = 'uploaded[shp_file]|ext_in[shp_file,shp]';
            $rules['shx_file'] = 'uploaded[shx_file]|ext_in[shx_file,shx]';
            $rules['dbf_file'] = 'uploaded[dbf_file]|ext_in[dbf_file,dbf]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $geometry = null;

        if ($uploadType === 'geojson') {
            // Handle GeoJSON upload
            $file = $this->request->getFile('geojson_file');
            $geoJsonContent = file_get_contents($file->getTempName());

            $json = json_decode($geoJsonContent, true);
            if (!$json || !isset($json['type'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid GeoJSON file.');
            }

            if ($json['type'] === 'FeatureCollection' && !empty($json['features'])) {
                $geometry = json_encode($json['features'][0]['geometry']);
            }
            elseif ($json['type'] === 'Feature') {
                $geometry = json_encode($json['geometry']);
            }
            else {
                $geometry = $geoJsonContent;
            }
        }
        elseif ($uploadType === 'shapefile') {
            // Handle Shapefile upload
            $shpParser = new \App\Libraries\ShapefileParser();

            if (!$shpParser::isAvailable()) {
                return redirect()->back()->withInput()->with('error', 'Shapefile support requires ogr2ogr (GDAL) to be installed on the server.');
            }

            $files = [
                $this->request->getFile('shp_file'),
                $this->request->getFile('shx_file'),
                $this->request->getFile('dbf_file'),
            ];

            // Add optional PRJ file if uploaded
            if ($this->request->getFile('prj_file') && $this->request->getFile('prj_file')->isValid()) {
                $files[] = $this->request->getFile('prj_file');
            }

            $geoJsonArray = $shpParser->parseShapefile($files);

            if (!$geoJsonArray) {
                return redirect()->back()->withInput()->with('error', 'Failed to parse Shapefile. Please check the files.');
            }

            // Extract first feature geometry
            if (isset($geoJsonArray['features'][0]['geometry'])) {
                $geometry = json_encode($geoJsonArray['features'][0]['geometry']);
            }
            else {
                return redirect()->back()->withInput()->with('error', 'No geometry found in Shapefile.');
            }
        }

        $data = [
            'nama_zona' => $this->request->getPost('nama_zona'),
            'peruntukan' => $this->request->getPost('peruntukan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'color' => $this->request->getPost('color') ?? '#3b82f6',
            'regulation_text' => $this->request->getPost('regulation_text'),
            'kbli_allowed' => $this->request->getPost('kbli_allowed'),
            'kdb' => $this->nullIfEmpty($this->request->getPost('kdb')),
            'klb' => $this->nullIfEmpty($this->request->getPost('klb')),
            'kdh' => $this->nullIfEmpty($this->request->getPost('kdh')),
            'ktb' => $this->nullIfEmpty($this->request->getPost('ktb')),
            'ketinggian_max' => $this->nullIfEmpty($this->request->getPost('ketinggian_max')),
            'jumlah_lantai_max' => $this->nullIfEmpty($this->request->getPost('jumlah_lantai_max')),
            'gsb' => $this->nullIfEmpty($this->request->getPost('gsb')),
            'gsl' => $this->nullIfEmpty($this->request->getPost('gsl')),
            'sub_zona' => $this->request->getPost('sub_zona'),
            'arahan_pemanfaatan' => $this->request->getPost('arahan_pemanfaatan'),
        ];

        $model = new \App\Models\RdtrModel();
        if ($model->insertGeoJSON($data, $geometry)) {
            return redirect()->to('admin/rdtr')->with('success', 'Data RDTR berhasil disimpan.');
        }
        else {
            return redirect()->back()->withInput()->with('error', 'Failed to save data to database.');
        }
    }

    public function edit($id)
    {
        $model = new \App\Models\RdtrModel();
        $zone = $model->find($id);

        if (!$zone) {
            return redirect()->to('admin/rdtr')->with('error', 'Data tidak ditemukan.');
        }

        $activityModel = new \App\Models\ActivityModel();
        $templateModel = new \App\Models\ActivityTemplateModel();

        $data = [
            'zone' => $zone,
            'activities' => $activityModel->where('rdtr_zone_id', $id)->findAll(),
            'templates' => $templateModel->findAll()
        ];

        return view('admin/rdtr/edit', $data);
    }

    public function update($id)
    {
        $model = new \App\Models\RdtrModel();
        $zone = $model->find($id);

        if (!$zone) {
            return redirect()->to('admin/rdtr')->with('error', 'Data tidak ditemukan.');
        }

        $rules = [
            'nama_zona' => 'required',
            'peruntukan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_zona' => $this->request->getPost('nama_zona'),
            'peruntukan' => $this->request->getPost('peruntukan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'color' => $this->request->getPost('color') ?? $zone['color'],
            'regulation_text' => $this->request->getPost('regulation_text'),
            'kbli_allowed' => $this->request->getPost('kbli_allowed'),
            'kdb' => $this->nullIfEmpty($this->request->getPost('kdb')),
            'klb' => $this->nullIfEmpty($this->request->getPost('klb')),
            'kdh' => $this->nullIfEmpty($this->request->getPost('kdh')),
            'ktb' => $this->nullIfEmpty($this->request->getPost('ktb')),
            'ketinggian_max' => $this->nullIfEmpty($this->request->getPost('ketinggian_max')),
            'jumlah_lantai_max' => $this->nullIfEmpty($this->request->getPost('jumlah_lantai_max')),
            'gsb' => $this->nullIfEmpty($this->request->getPost('gsb')),
            'gsl' => $this->nullIfEmpty($this->request->getPost('gsl')),
            'sub_zona' => $this->request->getPost('sub_zona'),
            'arahan_pemanfaatan' => $this->request->getPost('arahan_pemanfaatan'),
        ];

        $model->update($id, $data);
        return redirect()->to('admin/rdtr')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new \App\Models\RdtrModel();
        $model->delete($id);
        return redirect()->to('admin/rdtr')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $model = new \App\Models\RdtrModel();
        $zones = $model->findAll();

        $dompdf = new Dompdf();
        $html = view('admin/rdtr/pdf_export', ['zones' => $zones]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Laporan_Zonasi_RDTR.pdf", ["Attachment" => true]);
    }

    public function addActivity()
    {
        $model = new \App\Models\ActivityModel();

        $data = [
            'rdtr_zone_id' => $this->request->getPost('rdtr_zone_id'),
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'kategori_kegiatan' => $this->request->getPost('kategori_kegiatan'),
            'status' => $this->request->getPost('status'),
            'syarat' => $this->request->getPost('syarat'),
        ];

        if ($model->save($data)) {
            return $this->response->setJSON(['status' => true, 'message' => 'Kegiatan berhasil ditambahkan.']);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan kegiatan.']);
    }

    public function deleteActivity($id)
    {
        $model = new \App\Models\ActivityModel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['status' => true, 'message' => 'Kegiatan berhasil dihapus.']);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus kegiatan.']);
    }

    private function nullIfEmpty($value)
    {
        return ($value === "" || $value === null) ? null : $value;
    }
}