<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class SupplierDataModel extends Model
{
    protected $table            = 'sp_supplier_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama'];

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
        'nama' => ['label' => 'Supplier', 'rules' => 'required|max_length[100]']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
