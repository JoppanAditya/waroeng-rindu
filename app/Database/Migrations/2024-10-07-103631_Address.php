<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Address extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'city' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'province' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'postal_code' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'full_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'notes' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'is_default' => [
                'type'           => 'INT',
                'constraint'     => '1',
                'unsigned'       => true,
            ],
            'is_selected' => [
                'type'           => 'INT',
                'constraint'     => '1',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
