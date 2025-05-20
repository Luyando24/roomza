<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
            'verify properties',
            'manage users',
            'manage bookings',
            'manage reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $businessRole = Role::create(['name' => 'business']);
        $businessRole->givePermissionTo([
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
        ]);

        $personalRole = Role::create(['name' => 'personal']);
        $personalRole->givePermissionTo([
            'view properties',
        ]);

        // Assign roles to existing users based on business_type
        $users = User::all();
        foreach ($users as $user) {
            if ($user->business_type === 'business') {
                $user->assignRole('business');
            } else {
                $user->assignRole('personal');
            }
        }
    }
}