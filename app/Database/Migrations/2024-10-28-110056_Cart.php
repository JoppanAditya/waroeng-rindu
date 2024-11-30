<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cart extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['Shopping', 'Wishlist'],
                'default'    => 'Shopping',
            ],
            'menu_id' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'user_id' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'quantity' => [
                'type'      => 'INT',
                'unsigned'  => true,
            ],
            'price' => [
                'type'      => 'FLOAT',
                'unsigned'  => true,
            ],
            'subtotal' => [
                'type'      => 'FLOAT',
                'unsigned'  => true,
            ],
            'notes' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cart');
    }

    public function down()
    {
        $this->forge->dropTable('cart');
    }
}
