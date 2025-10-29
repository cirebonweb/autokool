<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\InvoiceMasterModel;

class InvoiceMaster extends BaseController
{
    protected $invoiceMasterModel;

    public function __construct()
    {
        $this->invoiceMasterModel = new InvoiceMasterModel();
    }

    public function index()
    {
        $tipe = $this->request->getGet('t');

        if (!in_array($tipe, ['Mengajukan', 'Mengetahui', 'Menyetujui', 'Divisi'])) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Tipe tidak dikenali']);
        }

        $data = $this->invoiceMasterModel->tipe($tipe);

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }

    public function tabel()
    {
        $data = $this->invoiceMasterModel->findAll();
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setJSON($data);
    }

    public function simpan()
    {
        try {
            $data = $this->request->getJSON(true);

            if (empty($data['id'])) {
                if (! $this->invoiceMasterModel->insert($data)) {
                    throw new \Exception("Gagal insert: " . json_encode($this->invoiceMasterModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.insert-success")]);
            } else {
                if (! $this->invoiceMasterModel->update($data['id'], $data)) {
                    throw new \Exception("Gagal update: " . json_encode($this->invoiceMasterModel->errors()));
                }
                return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
            }
        } catch (\Throwable $e) {
            log_message('error', '[Api\InvoiceMaster::simpan] ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }

    public function detail($id)
    {
        $data = $this->invoiceMasterModel->find($id);

        if (! $data) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }
}
