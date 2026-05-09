<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Defined permissions per module
        $permissions = [
            // Core
            'core.tenant.view',
            'core.tenant.create',
            'core.tenant.edit',
            'core.tenant.delete',

            'core.company.view',
            'core.company.create',
            'core.company.edit',
            'core.company.delete',

            'core.branch.view',
            'core.branch.create',
            'core.branch.edit',
            'core.branch.delete',

            'core.setting.view',
            'core.setting.edit',

            // User Management
            'core.user.view',
            'core.user.create',
            'core.user.edit',
            'core.user.delete',

            'core.role.view',
            'core.role.create',
            'core.role.edit',
            'core.role.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $admin      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user       = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Superadmin gets all permissions
        $superadmin->syncPermissions(Permission::all());

        // Admin gets all except tenant management
        $adminPermissions = Permission::whereNotIn('name', [
            'core.tenant.create',
            'core.tenant.delete',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // User gets only view permissions
        $userPermissions = Permission::where('name', 'like', '%.view')->get();
        $user->syncPermissions($userPermissions);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
