<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'HOD']);

        $user = User::firstOrCreate(
            ['email' => 'hod@jnec.edu.bt'],
            ['name' => 'HOD', 'password' => bcrypt('password')]
        );

        $user->assignRole('hod');
    }
}
