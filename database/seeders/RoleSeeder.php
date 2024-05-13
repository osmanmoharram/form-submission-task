<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var array<int, string> */
        $roles = ['hr_coordinator', 'hr_manager'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
