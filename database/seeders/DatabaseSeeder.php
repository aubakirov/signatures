<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'is_admin' => 1,
                'password' => bcrypt('1234567'),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'is_admin' => 0,
                'password' => bcrypt('1234567')
            ]
        ];

        DB::table('users')->insert($users);
    }
}
