<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatSupplierBank extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'supplier_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'kode' => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'bank' => ['type' => 'varchar', 'constraint' => 15],
            'rekening' => ['type' => 'varchar', 'constraint' => 50],
            'pemilik' => ['type' => 'varchar', 'constraint' => 100],
            'dibuat' => ['type' => 'datetime', 'null' => true],
            'dirubah' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier_id', 'sp_supplier_data', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('sp_supplier_bank');
    }

    public function down()
    {
        $this->forge->dropTable('sp_supplier_bank');
    }
}
