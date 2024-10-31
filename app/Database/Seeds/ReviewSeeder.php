<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'menu_id' => 1,
                'user_id' => 8,
                'rating' => 5,
                'parent_id' => 0,
                'comment' => 'Wah nasi goreng mantap bro',
                'created_at' => Time::now(),
            ],
            [
                'menu_id' => 1,
                'user_id' => 4,
                'rating' => NULL,
                'parent_id' => 1,
                'comment' => 'Yang bener?',
                'created_at' => Time::now(),
            ],
        ];

        $this->db->table('reviews')->insertBatch($data);
    }
}
