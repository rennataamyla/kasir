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
}