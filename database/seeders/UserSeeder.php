<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'role_id' => 1,
                'username' => 'super.admin',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'role_id' => 2,
                'username' => 'operator',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'role_id' => 3,
                'username' => 'student',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ]
        ];

        foreach($users as $user) {
            User::create($user);
        }

        User::factory(17)->create();
    }
}
