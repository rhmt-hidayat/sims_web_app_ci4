<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\ProductModel;
use Codeigniter\API\ResponseTrait;

class Profil extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $UserModel = new UserModel();

        return $this->respond([
            'data' => $UserModel->findAll()
        ], 200);
    }

    public function produk()
    {
        $ProdukModel = new ProductModel();

        return $this->respond([
            'Produk' => $ProdukModel->findAll()
        ], 200);
    }
}
