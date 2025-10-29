<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\InvoiceIsiModel;

class InvoiceIsi extends BaseController
{
    protected $invoiceIsiModel;

    public function __construct()
    {
        $this->invoiceIsiModel = new InvoiceIsiModel();
    }

    public function tabel($invoiceSpId)
    {
        $data = $this->invoiceIsiModel->tabel($invoiceSpId);
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')->setJSON($data);
    }

    public function getId($id)
    {
        $data = $this->invoiceIsiModel->getId($id);

        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Isi invoice tidak ditemukan']);
        }

        return $this->response->setJSON($data);
    }
}
