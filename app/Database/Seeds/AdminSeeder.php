<?php

namespace App\Database\Seeds;

use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        $userData = [
            [
                'username' => 'joppan',
                'email'    => 'akunku.rising808@passmail.net',
                'password' => 'Waroengrindujaya1',
                'fullname' => 'Joppan Aditya',
                'gender'   => 'Male',
                'image'    => 'profile-img.jpg',
                'group'    => ['superadmin'],
            ],
            [
                'username' => 'sulfia',
                'email'    => 'sulfia@mail.com',
                'password' => 'Waroengrindujaya1',
                'fullname' => 'Sulfia',
                'gender'   => 'Female',
                'image'    => 'default.jpg',
                'group'    => ['superadmin'],
            ],
            [
                'username' => 'mimi',
                'email'    => 'mimi@mail.com',
                'password' => 'Waroengrindujaya1',
                'fullname' => 'Mimi Sinaga',
                'gender'   => 'Female',
                'image'    => 'default.jpg',
                'group'    => ['superadmin'],
            ],
            [
                'username' => 'admin',
                'email'    => 'admin@mail.com',
                'password' => 'Waroengrindujaya1',
                'fullname' => 'Waroeng Rindu',
                'gender'   => NULL,
                'image'    => 'default.jpg',
                'group'    => ['admin'],
            ],
        ];

        foreach ($userData as $data) {
            $user = new User([
                'username' => $data['username'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'fullname' => $data['fullname'],
                'gender'   => $data['gender'],
                'image'    => $data['image'],
            ]);
            $users->save($user);

            $user = $users->findById($users->getInsertID());
            foreach ($data['group'] as $group) {
                $user->syncGroups($group);
            }
        }
    }
}
