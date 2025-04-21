<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin: userLevel =0, Alumni: userLevel = 1
        $users = [
            [
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=> bcrypt('12345678'),
                'user_level' => 0,
                'ic_passport' => '0000',
            ],
            [
                'name'=>'Ahmad Ali',
                'email'=>'aali@gmail.com',
                'password'=> bcrypt('12345678'),
                'user_level' => 1,
                'ic_passport' => '2222',
            ],
        ];

        // foreach item in the $users array (above), create user
        foreach ($users as $key => $user) {
            User::create($user);
        }

    }
}
