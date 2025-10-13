<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatSpInvoiceMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'varchar', 'constraint' => 100],
            'tipe' => ['type' => 'varchar', 'constraint' => 10],
            'dibuat' => ['type' => 'datetime', 'null' => true],
            'dirubah' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sp_invoice_master');
    }

    public function down()
    {
        $this->forge->dropTable('sp_invoice_master');
    }
}
