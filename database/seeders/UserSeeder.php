<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        $users = [
            [
                'name' => 'Osman Moharram',
                'email' => 'osman@example.com',
                'password' => Hash::make(123)
            ],

            [
                'name' => 'Mohammed Moharram',
                'email' => 'mohammed@example.com',
                'password' => Hash::make(678)
            ]
        ];

        foreach ($users as $usr) {
            User::create($usr);
        }
    }
}
