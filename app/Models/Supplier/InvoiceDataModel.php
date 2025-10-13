<?php

namespace App\Models\Supplier;

use CodeIgniter\Model;

class InvoiceDataModel extends Model
{
    protected $table            = 'sp_invoice_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'divisi', 'mengajukan', 'mengetahui', 'menyetujui', 'total'];

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
        'tanggal' => ['label' => 'Tanggal', 'rules' => 'required|valid_date'],
        'divisi' => ['label' => 'Divisi', 'rules' => 'required|string|max_length[100]'],
        'mengajukan' => ['label' => 'Mengajukan', 'rules' => 'required|string|max_length[100]'],
        'mengetahui' => ['label' => 'Mengetahui', 'rules' => 'required|string|max_length[100]'],
        'menyetujui' => ['label' => 'Menyetujui', 'rules' => 'required|string|max_length[100]'],
        'total' => ['label' => 'Total', 'rules' => 'required|decimal']
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
