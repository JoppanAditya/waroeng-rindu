<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transacions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'address_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'total_price' => [
                'type'           => 'INT',
                'constraint'     => '20',
                'unsigned'       => true,
            ],
            'status' => [
                'type'           => 'INT',
                'constraint'     => '1',
                'unsigned'       => true,
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'created_at' => [
                'type'  => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
