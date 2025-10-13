<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\SupplierBankModel;

class SupplierBank extends BaseController
{
    protected $supplierBankModel;

    public function __construct()
    {
        $this->supplierBankModel = new SupplierBankModel();
    }

    public function tabel()
    {
        $data = $this->supplierBankModel->tabel();
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setJSON($data);
    }

    public function simpan()
    {
        try {
            $data = $this->request->getJSON(true);

            if (empty($data['id'])) {
                if (! $this->supplierBankModel->insert($data)) {
                    throw new \Exception("Gagal insert: " . json_encode($this->supplierBankModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.insert-success")]);
            } else {
                if (! $this->supplierBankModel->update($data['id'], $data)) {
                    throw new \Exception("Gagal update: " . json_encode($this->supplierBankModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
            }
        } catch (\Throwable $e) {
            log_message('error', '[Api\SupplierBank:simpan] ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }

    public function detail($id = null)
    {
        $data = $this->supplierBankModel->find($id);

        if (! $data) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }
}
