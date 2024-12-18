<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transacions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'user_id' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'address_id' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'courier' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
            ],
            'courier_service' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'delivery_fee' => [
                'type'      => 'FLOAT',
                'unsigned'  => true,
            ],
            'total_price' => [
                'type'      => 'FLOAT',
                'unsigned'  => true,
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'is_reviewed' => [
                'type'           => 'INT',
                'constraint'     => '1',
                'unsigned'       => true,
            ],
            'expiry_time' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
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
