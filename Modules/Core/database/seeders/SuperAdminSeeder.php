<?php

namespace Modules\Core\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Models\Company;
use Modules\Core\Models\Tenant;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for main tenant
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'riyerp'],
            [
                'name' => 'RiyErp',
                'email' => 'admin@riyerp.com',
                'status' => 'active',
            ]);

        // for main company
        $company = Company::firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'RiyErp HQ'],
            [
                'tenant_id' => $tenant->id,
                'currency' => 'IDR',
                'is_default' => true,
                'country' => 'ID',
                'timezone' => 'Asia/Jakarta',
                'status' => 'active',
            ]);

        // Create superadmin user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@riyerp.local'],
            [
                'tenant_id' => $tenant->id,
                'company_id' => $company->id,
                'name' => 'Super Admin',
                'email' => 'superadmin@riyerp.local',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]);

        $user ->assignRole('superadmin');

        $this->command->info('✅ Superadmin user successfully created.');
        $this->command->info('Email: superadmin@riyerp.local');
        $this->command->info('Password: "password"');
        $this->command->warn('⚠️ Please change the password immediately after login!');
    }
}
