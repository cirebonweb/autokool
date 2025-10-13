<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class SupplierBankModel extends Model
{
    protected $table            = 'sp_supplier_bank';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['supplier_id', 'kode', 'bank', 'rekening', 'pemilik'];

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
        'supplier_id' => ['label' => 'Id Supllier', 'rules' => 'required|integer'],
        'kode' => ['label' => 'Kode Bank', 'rules' => 'permit_empty|max_length[10]'],
        'bank' => ['label' => 'Nama Bank', 'rules' => 'required|max_length[15]'],
        'rekening' => ['label' => 'No. Rekening', 'rules' => 'required|max_length[50]'],
        'pemilik' => ['label' => 'Nama Pemilik', 'rules' => 'required|max_length[100]']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function tabel()
	{
		return $this
        ->from('sp_supplier_bank a')
        ->select('a.id bank_id, b.nama, a.kode, a.bank, a.rekening, a.pemilik, a.dibuat, a.dirubah')
        ->join('sp_supplier_data b', 'b.id = a.supplier_id')
        ->findAll();
	}
}
