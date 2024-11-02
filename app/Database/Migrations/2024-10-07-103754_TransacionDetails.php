<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransacionDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'menu_id' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'menu_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'menu_price' => [
                'type'      => 'FLOAT',
                'unsigned'  => true,
            ],
            'quantity' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'notes' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_details');
    }
}
