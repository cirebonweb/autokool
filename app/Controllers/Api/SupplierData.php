<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\SupplierDataModel;

class SupplierDaata extends BaseController
{
    protected $supplierDataModel;

    public function __construct()
    {
        $this->supplierDataModel = new SupplierDataModel();
    }

    public function tabel()
    {
        $data = $this->supplierDataModel->findAll();
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setJSON($data);
    }

    public function simpan()
    {
        try {
            $data = $this->request->getJSON(true);

            if (empty($data['id'])) {
                if (! $this->supplierDataModel->insert($data)) {
                    throw new \Exception("Gagal insert: " . json_encode($this->supplierDataModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.insert-success")]);
            } else {
                if (! $this->supplierDataModel->update($data['id'], $data)) {
                    throw new \Exception("Gagal update: " . json_encode($this->supplierDataModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
            }
        } catch (\Throwable $e) {
            log_message('error', '[Api\Supplier:simpan] ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }

    public function detail($id = null)
    {
        $data = $this->supplierDataModel->find($id);

        if (! $data) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }
}
