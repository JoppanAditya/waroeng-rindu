<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuCategory extends Migration
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
                'type'          => 'VARCHAR',
                'constraint'    => '128'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu_categories');
    }

    public function down()
    {
        $this->forge->dropTable('menu_categories');
    }
}
