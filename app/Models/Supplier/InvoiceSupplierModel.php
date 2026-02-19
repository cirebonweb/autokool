<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class InvoiceSupplierModel extends Model
{
    protected $table            = 'sp_invoice_supplier';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_data_id', 'supplier_data_id', 'supplier_bank_id', 'no_invoice', 'no_pajak', 'tgl_buat', 'tgl_tempo', 'jumlah'];

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
        'supplier_data_id' => ['label' => 'ID Supplier Data', 'rules' => 'required|integer'],
        'supplier_bank_id' => ['label' => 'ID Supplier Bank', 'rules' => 'required|integer'],
        'no_invoice' => ['label' => 'Nomor Invoice', 'rules' => 'required|string|max_length[50]'],
        'no_pajak' => ['label' => 'Nomor Pajak', 'rules' => 'permit_empty|string|max_length[50]'],
        'tgl_buat' => ['label' => 'Tanggal Buat', 'rules' => 'required|valid_date'],
        'tgl_tempo' => ['label' => 'Tanggal Tempo', 'rules' => 'required|valid_date'],
        'jumlah' => ['label' => 'Jumlah', 'rules' => 'required|decimal']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function tabelData($invoiceId)
    {
        return $this
            ->select('
            sp_invoice_supplier.invoice_data_id,
            sp_invoice_supplier.supplier_data_id,
            sp_invoice_supplier.supplier_bank_id,
            sp_supplier_data.nama,
            SUM(sp_invoice_supplier.jumlah) subtotal,
            sp_supplier_bank.bank,
            sp_supplier_bank.rekening')
            ->join('sp_supplier_data', 'sp_supplier_data.id = sp_invoice_supplier.supplier_data_id')
            ->join('sp_supplier_bank', 'sp_supplier_bank.id = sp_invoice_supplier.supplier_bank_id')
            ->where('invoice_data_id', $invoiceId)
            ->groupBy('sp_invoice_supplier.supplier_data_id')
            ->findAll();
    }

    public function tabelIsi($invoiceId, $supplierId)
    {
        return $this
            ->select('id, no_invoice, no_pajak, tgl_buat, tgl_tempo, jumlah, dibuat, dirubah')
            ->where('invoice_data_id', $invoiceId)
            ->where('supplier_data_id', $supplierId)
            ->findAll();
    }

    public function hitungIsi($invoiceId)
    {
        return $this
            ->where('invoice_data_id', $invoiceId)
            ->countAllResults();
    }

    public function printIsi($invoiceId)
    {
        return $this
            ->select('supplier_data_id, no_invoice, no_pajak, tgl_buat, tgl_tempo, jumlah,
            a.nama, b.bank, b.rekening, b.pemilik')
            ->join('sp_supplier_data a', 'a.id = sp_invoice_supplier.supplier_data_id')
            ->join('sp_supplier_bank b', 'b.id = sp_invoice_supplier.supplier_bank_id')
            ->where('invoice_data_id', $invoiceId)
            ->orderBy('sp_invoice_supplier.id', 'ASC')
            ->findAll();
    }

    public function printIsiTes1()
    {
        return $this
            ->select('jumlah')
            ->where('id', 1277)
            ->where('id', 189)
            ->first();
    }

    public function printIsiTes()
    {
        return $this
            ->select('id, jumlah')
            ->whereIn('id', [1277, 189])
            ->findAll();
    }
}
