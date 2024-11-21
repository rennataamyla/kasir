<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class Product extends BaseController
{
    protected $produkmodel;
    public function __construct()
    {
        $this->produkmodel = new ProdukModel();
    }
    public function index()
    {
        $model = new ProdukModel();
        $produk = $model->findAll();  // Ambil semua produk

        // Kirimkan data produk ke view
        return view('v_produk', ['produk' => $produk]);
    }

    public function tampil_products()
    {
        $produk = $this->produkmodel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'produk' => $produk
        ]);
    }

    public function perbarui()
    {
        $id = $this->request->getVar('produk_id');

        // Validasi input dari AJAX
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_produk' => 'required',
            'harga'       => 'required|decimal',
            'stok'        => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok'        => $this->request->getVar('stok'),
        ];

        // Update produk
        $this->produkmodel->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data produk berhasil diupdate',
        ]);
    }
    public function simpan_produk()
    {
        //validasi input dari AJAX
        $validation = \config\Services::validation();

        $validation->setRules([
            'nama_produk'   => 'required',
            'harga'         => 'required|decimal',
            'stok'          => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'    => 'error',
                'errors'    => $validation->getErrors(),
            ]);
        }
        $data = [
            'nama_produk'  => $this->request->getVar('nama_produk'),
            'harga'         => $this->request->getVar('harga'),
            'stok'          => $this->request->getVar('stok'),
        ];
        

        $this->produkmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan',
        ]);
    }

    public function edit_produk()
    {
        $produkID = $this->request->getVar('id');
        $model = new ProdukModel();
        $produk = $model->find($produkID);

        if ($produk) {
            return $this->response->setJSON($produk);  // Kirimkan data produk dalam format JSON
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }
    }

    public function delete($id)
    {
        $model = new ProdukModel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'gagal menghapus data']);
        }
    }
}
