<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddAttrToUser extends Migration
{
    /**
     * @var string[]
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
            'fullname' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'mobile_number' => ['type' => 'VARCHAR', 'constraint' => '15', 'null' => true],
            'date_of_birth' => ['type' => 'DATE', 'null' => true],
            'gender' => ['type' => 'VARCHAR', 'constraint' => '6', 'null' => true],
            'image' => ['type' => 'VARCHAR',  'constraint' => '255',   'default' => 'default.jpg'],
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'fullname',
            'mobile_number',
            'date_of_birth',
            'gender',
            'image',
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
