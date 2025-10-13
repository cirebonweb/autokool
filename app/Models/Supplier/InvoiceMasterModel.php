<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class InvoiceMasterModel extends Model
{
    protected $table            = 'sp_invoice_master';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'nama', 'tipe'];

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
        'nama' => ['label' => 'Nama', 'rules' => 'required|max_length[100]'],
        'tipe' => ['label' => 'Tipe', 'rules' => 'required|max_length[10]']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function tipe($tipe)
    {
        return $this
            ->select('id, nama, tipe')
            ->where('tipe', $tipe)
            ->findAll();
    }
}
