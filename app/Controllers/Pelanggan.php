<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pelanggan extends BaseController
{
    protected $pelangganmodel;
    public function __construct()
    {
        $this->pelangganmodel = new PelangganModel();
    }
    public function index()
    {
        $model = new PelangganModel();
        $pelanggan  = $model->findAll();  // Ambil semua produk

        // Kirimkan data produk ke view
        return view('v_pelanggan', ['pelanggan' => $pelanggan]);
    }

    public function tampil_pelanggan()
    {
        $produk = $this->pelangganmodel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'produk' => $produk
        ]);
    }
    public function simpan_pelanggan()
    {
        //validasi input dari AJAX
        $validation = \config\Services::validation();

        $validation->setRules([
            'nama_pelanggan'   => 'required',
            'alamat'         => 'required',
            'no_tlp'          => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'    => 'error',
                'errors'    => $validation->getErrors(),
            ]);
        }
        $data = [
            'nama_pelanggan'  => $this->request->getVar('nama_pelanggan'), // Perbaiki nama variabel
            'alamat'           => $this->request->getVar('alamat'),
            'no_tlp'           => $this->request->getVar('no_tlp'),
        ];

        

        $this->pelangganmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan',
        ]);
    }

    public function delete($id)
    {
        $model = new pelangganmodel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'gagal menghapus data']);
        }
    }

    public function edit_pelanggan()
    {
        $id = $this->request->getVar('id');
        $model = new pelangganmodel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON($data);  // Kirimkan data produk dalam format JSON
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }
    }
    public function perbarui()
    {
        $id = $this->request->getVar('id_pelanggan');

        // Validasi input dari AJAX
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat'       => 'required',
            'no_tlp'        => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat' => $this->request->getVar('alamat'),
            'no_tlp'        => $this->request->getVar('no_tlp'),
        ];

        // Update produk
        $this->pelangganmodel->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data produk berhasil diupdate',
        ]);
    }

      
}