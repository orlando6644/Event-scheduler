<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Example users to test the application
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'test1@test.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'test2@test.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Paul Walker',
                'email' => 'test3@test.com',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create($user);
            }
        }
    }
}
