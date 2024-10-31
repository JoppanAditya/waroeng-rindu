<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reviews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'menu_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'user_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'parent_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'  => true,
            ],
            'rating' => [
                'type'       => 'int',
                'unsigned'   => true,
                'constraint' => '1',
                'null'       => true,
            ],
            'comment' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type'  => 'DATETIME',
            ],
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('reviews');
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}
