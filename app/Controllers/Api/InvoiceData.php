<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Supplier\InvoiceDataModel;
use App\Models\Supplier\InvoiceSupplierModel;
// use App\Models\Supplier\InvoiceIsiModel;

class InvoiceData extends BaseController
{
    protected $invoiceDataModel;
    protected $invoiceSupplierModel;
    // protected $invoiceIsiModel;

    public function __construct()
    {
        $this->invoiceDataModel = new InvoiceDataModel();
        $this->invoiceSupplierModel = new InvoiceSupplierModel();
        // $this->invoiceIsiModel = new InvoiceIsiModel();
    }

    public function getIdTgl($tanggal)
    {
        $id = $this->invoiceDataModel->getIdTgl($tanggal);

        if ($id) {
            return $this->response->setJSON(['success' => true, 'messages' => 'Tanggal invoice sudah ada']);
        }

        return $this->response->setJSON(['success' => false, 'messages' => 'OK']);
    }

    public function getTahun()
    {
        $tahun = $this->invoiceDataModel->getTahun();

        if (empty($tahun)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Tahun invoice data tidak ditemukan']);
        }

        return $this->response->setJSON($tahun);
    }

    public function getBulan()
    {
        $bulan = $this->invoiceDataModel->getBulan();

        if (empty($bulan)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'bulan invoice data tidak ditemukan']);
        }

        return $this->response->setJSON($bulan);
    }

    public function getTtd($id)
    {
        $data = $this->invoiceDataModel->getTtd($id);

        if ($data === null) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON(['success'  => true, 'data' => $data]);
    }

    public function tabel($tahun = null, $bulan = null)
    {
        $builder = $this->invoiceDataModel->select('*');

        if ($tahun) {
            $builder->where('YEAR(tanggal)', $tahun);
        }
        if ($bulan && $bulan !== 'Semua') {
            $builder->where('MONTH(tanggal)', $bulan);
        }

        $data = $builder->findAll();

        return $this->response->setHeader('Access-Control-Allow-Origin', '*')->setJSON($data);
    }

    public function simpan()
    {
        $this->db->transBegin();

        try {
            $data = $this->request->getJSON(true);

            // Insert ke sp_invoice_data
            $invoiceData = [
                'tanggal'     => $data['tanggal'],
                'divisi'      => $data['divisi'],
                'mengajukan'  => $data['mengajukan'],
                'mengetahui'  => $data['mengetahui'],
                'menyetujui'  => $data['menyetujui']
            ];

            if (! $this->invoiceDataModel->insert($invoiceData)) {
                return $this->response->setJSON([
                    'success' => false,
                    'messages' => 'Validasi Invoice Data',
                    'errors' => $this->invoiceDataModel->errors()
                ]);
            }

            $lastIdInvData = $this->invoiceDataModel->getInsertID();

            // Loop insert sp_invoice_supplier
            foreach ($data['sp'] as $sp) {
                $sp['invoice_data_id'] = $lastIdInvData;

                if (! $this->invoiceSupplierModel->insert($sp)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'messages' => 'Validasi Invoice Supplier',
                        'errors' => $this->invoiceSupplierModel->errors()
                    ]);
                }
            }

            $this->db->transCommit();

            return $this->response->setJSON([
                'success'  => true,
                'messages' => 'Invoice berhasil disimpan',
                'id'       => $lastIdInvData
            ]);
        } catch (\Throwable $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Gagal simpan invoice: ' . $e->getMessage()
            ]);
        }
    }

    public function hapus($id)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Error 400: ID invoice tidak ditemukan.'
            ])->setStatusCode(400);
        }

        try {
            $data = $this->invoiceDataModel->find($id);
            if (!$data) {
                return $this->response->setJSON([
                    'success'  => false,
                    'messages' => 'Error 404: Data invoice id tidak ditemukan.'
                ])->setStatusCode(404);
            }

            if (!$this->invoiceDataModel->delete($id)) {
                return $this->response->setJSON([
                    'success'  => false,
                    'messages' => 'Error 500: Gagal menghapus data invoice.'
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
}
