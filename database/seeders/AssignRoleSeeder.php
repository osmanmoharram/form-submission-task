<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($hrCoordinator = User::where('email', 'osman@example.com')->first()) {
            $hrCoordinator->assignRole('hr_coordinator');
        }

        if ($hrManager = User::where('email', 'mohammed@example.com')->first()) {
            $hrManager->assignRole('hr_manager');
        }
    }
}
