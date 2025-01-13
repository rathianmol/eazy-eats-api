<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create Super Admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@eazyeats.com',
            'password' => bcrypt('password123'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@eazyeats.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole($adminRole);

        // Create Test User 1
        $testUser1 = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@eazyeats.com',
            'password' => bcrypt('password123'),
        ]);
        $testUser1->assignRole($userRole);

        $this->command->info('Roles and users seeded successfully!');
    }
}
