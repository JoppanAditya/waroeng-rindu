<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'category_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'description' => [
                'type'       => 'TEXT',
            ],
            'price' => [
                'type'           => 'INT',
                'constraint'     => '20',
                'unsigned'       => true,
            ],
            'image' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menus');
    }

    public function down()
    {
        $this->forge->dropTable('menus');
    }
}
