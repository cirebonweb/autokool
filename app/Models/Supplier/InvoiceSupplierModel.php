<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class InvoiceSupplierModel extends Model
{
    protected $table            = 'sp_invoice_sp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_data_id', 'supplier_data_id', 'supplier_bank_id', 'total'];

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
        'total' => ['label' => 'Total', 'rules' => 'required|decimal']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
