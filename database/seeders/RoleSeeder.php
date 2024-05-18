<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();
        
        /** @var array<int, string> */
        $roles = ['hr_coordinator', 'hr_manager'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
