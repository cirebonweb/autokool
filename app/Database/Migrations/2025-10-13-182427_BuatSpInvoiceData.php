<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatSpInvoiceData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal' => ['type' => 'date'],
            'divisi' => ['type' => 'varchar', 'constraint' => 100],
            'mengajukan' => ['type' => 'varchar', 'constraint' => 100],
            'mengetahui' => ['type' => 'varchar', 'constraint' => 100],
            'menyetujui' => ['type' => 'varchar', 'constraint' => 100],
            'total' => ['type' => 'decimal', 'constraint' => 15, 2],
            'dibuat' => ['type' => 'datetime', 'null' => true],
            'dirubah' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('tanggal');
        $this->forge->createTable('sp_invoice_data');
    }

    public function down()
    {
        $this->forge->dropTable('sp_invoice_data');
    }
}
