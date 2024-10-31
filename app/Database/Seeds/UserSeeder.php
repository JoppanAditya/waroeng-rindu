<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $users = auth()->getProvider();

        for ($i = 0; $i < 16; $i++) {
            $userData[] = [
                'username'      => $faker->userName,
                'email'         => $faker->unique()->safeEmail,
                'password'      => 'password123',
                'fullname'      => $faker->name,
                'mobile_number' => $faker->phoneNumber,
                'date_of_birth' => $faker->date('Y-m-d', '2005-12-31'),
                'gender'        => $faker->randomElement(['Male', 'Female']),
                'image'         => 'default.jpg',
            ];
        }

        foreach ($userData as $data) {
            $user = new User([
                'username'      => $data['username'],
                'email'         => $data['email'],
                'password'      => $data['password'],
                'fullname'      => $data['fullname'],
                'mobile_number' => $data['mobile_number'],
                'date_of_birth' => $data['date_of_birth'],
                'gender'        => $data['gender'],
                'image'         => $data['image'],
            ]);
            $users->save($user);

            $user = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($user);
        }
    }
}
