<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransacionDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'transaction_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'menu_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'menu_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'menu_price' => [
                'type'           => 'INT',
                'constraint'     => '20',
                'unsigned'       => true,
            ],
            'quantity' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_details');
    }
}
