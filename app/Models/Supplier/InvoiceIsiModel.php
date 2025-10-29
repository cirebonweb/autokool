<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class InvoiceIsiModel extends Model
{
    protected $table            = 'sp_invoice_isi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_data_id', 'invoice_sp_id', 'no_invoice', 'no_pajak', 'tgl_buat', 'tgl_tempo', 'total'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat';
    protected $updatedField  = 'dirubah';
    protected $deletedField  = false;

    // Validation
    protected $validationRules      = [
        'invoice_data_id' => ['label' => 'ID Invoice Data', 'rules' => 'required|integer'],
        'invoice_sp_id' => ['label' => 'ID Invoice Supplier', 'rules' => 'required|integer'],
        'no_invoice' => ['label' => 'Nomor Invoice', 'rules' => 'required|string|max_length[50]'],
        'no_pajak' => ['label' => 'Nomor Pajak', 'rules' => 'permit_empty|string|max_length[50]'],
        'tgl_buat' => ['label' => 'Tanggal Buat', 'rules' => 'required|valid_date'],
        'tgl_tempo' => ['label' => 'Tanggal Tempo', 'rules' => 'required|valid_date'],
        'total' => ['label' => 'Total', 'rules' => 'required|decimal']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function tabel($invoiceSpId)
    {
        return $this
            ->select('no_invoice, no_pajak, tgl_buat, tgl_tempo, total, dibuat, dirubah')
            ->where('invoice_sp_id', $invoiceSpId)
            ->findAll();
    }

    public function getId($id)
    {
        return $this
            ->select('no_invoice, no_pajak, tgl_buat, tgl_tempo, total')
            ->where('id', $id)
            ->first();
    }
}
