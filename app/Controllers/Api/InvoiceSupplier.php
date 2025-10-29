<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\InvoiceSupplierModel;

class InvoiceSupplier extends BaseController
{
    protected $invoiceSupplierModel;

    public function __construct()
    {
        $this->invoiceSupplierModel = new InvoiceSupplierModel();
    }

    public function tabelData($invoiceId)
    {
        $data = $this->invoiceSupplierModel->tabelData($invoiceId);
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')->setJSON($data);
    }

    public function tabelIsi($invoiceId, $supplierId)
    {
        $data = $this->invoiceSupplierModel->tabelIsi($invoiceId, $supplierId);
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')->setJSON($data);
    }

    public function hitungIsi($invoiceId)
    {
        $jumlahIsi = $this->invoiceSupplierModel->hitungIsi($invoiceId);
        if (! $jumlahIsi) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Id invoice tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $jumlahIsi]);
    }

    public function printIsi($invoiceId)
    {
        $data = $this->invoiceSupplierModel->printIsi($invoiceId);
        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Id invoice tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }

    public function printIsiTes()
    {
        $data = $this->invoiceSupplierModel->printIsiTes();
        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Id invoice tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }

    public function hapus($id)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Error 400: ID isi invoice tidak ditemukan.'
            ])->setStatusCode(400);
        }

        try {
            $data = $this->invoiceSupplierModel->find($id);
            if (!$data) {
                return $this->response->setJSON([
                    'success'  => false,
                    'messages' => 'Error 404: Data isi invoice id tidak ditemukan.'
                ])->setStatusCode(404);
            }

            if (!$this->invoiceSupplierModel->delete($id)) {
                return $this->response->setJSON([
                    'success'  => false,
                    'messages' => 'Error 500: Gagal menghapus isi invoice.'
                ])->setStatusCode(500);
            }

            return $this->response->setJSON([
                'success'  => true,
                'messages' => lang("App.delete-success")
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Error 500: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function simpanIsi()
    {
        try {
            $data = $this->request->getJSON(true);

            if (empty($data['id'])) {
                if (! $this->invoiceSupplierModel->insert($data)) {
                    throw new \Exception("Gagal insert: " . json_encode($this->invoiceSupplierModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.insert-success")]);
            } else {
                if (! $this->invoiceSupplierModel->update($data['id'], $data)) {
                    throw new \Exception("Gagal update: " . json_encode($this->invoiceSupplierModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
            }
        } catch (\Throwable $e) {
            // log_message('error', '[Api\InvoiceSupplier::simpan] ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }
}
