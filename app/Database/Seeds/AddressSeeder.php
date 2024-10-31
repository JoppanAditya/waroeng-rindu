<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $addresses = [];

        $userIDs = $this->db->table('users')->select('id')->get()->getResultArray();

        foreach ($userIDs as $user) {
            $addressCount = rand(1, 3);

            for ($i = 0; $i < $addressCount; $i++) {
                $addresses[] = [
                    'user_id'      => $user['id'],
                    'name'         => $faker->name,
                    'phone'        => $faker->phoneNumber,
                    'label'        => $faker->randomElement(['Home', 'Office', 'Apartment']),
                    'city'         => $faker->city,
                    'full_address' => $faker->address,
                    'notes'        => $faker->optional()->sentence,
                    'is_default'   => $i === 0 ? 1 : 0,
                    'is_selected'  => $faker->numberBetween(0, 1),
                ];
            }
        }

        $this->db->table('address')->insertBatch($addresses);
    }
}
