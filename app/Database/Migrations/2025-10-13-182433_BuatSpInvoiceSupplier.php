<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatSpInvoiceSupplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'invoice_data_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'supplier_data_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'supplier_bank_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'no_invoice' => ['type' => 'varchar', 'constraint' => 50],
            'no_pajak' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'tgl_buat' => ['type' => 'date'],
            'tgl_tempo' => ['type' => 'date'],
            'jumlah' => ['type' => 'decimal', 'constraint' => 15, 2],
            'dibuat' => ['type' => 'datetime', 'null' => true],
            'dirubah' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('invoice_data_id', 'sp_invoice_data', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('supplier_data_id', 'sp_supplier_data', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('supplier_bank_id', 'sp_supplier_bank', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('sp_invoice_supplier');
    }

    public function down()
    {
        $this->forge->dropTable('sp_invoice_supplier');
    }
}
