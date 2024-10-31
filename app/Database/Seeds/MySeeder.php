<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MySeeder extends Seeder
{
    public function run()
    {
        $this->call('AdminSeeder');
        $this->call('UserSeeder');
        $this->call('AddressSeeder');
        $this->call('MenuSeeder');
        $this->call('ReviewSeeder');
    }
}
