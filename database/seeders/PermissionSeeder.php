<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ========= Permisos =========
        $permissions = [
            // Prospectos
            'view prospects',
            'create prospects',
            'edit prospects',
            'delete prospects',

            // Clientes
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            // Facturación
            'view billing',
            'edit billing',

            // Soporte
            'view support',
            'edit support',

            // Administración
            'view admin',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ========= Administrator — todo =========
        $administrator = Role::findByName('administrator');
        $administrator->syncPermissions($permissions);

        // ========= Agent — solo prospectos y clientes asignados =========
        $agent = Role::findByName('agent');
        $agent->syncPermissions([
            'view prospects',
            'create prospects',
            'edit prospects',
            'view customers',
            'edit customers',
        ]);

        // ========= Sales Agent — igual que agent =========
        $salesAgent = Role::findByName('sales-agent');
        $salesAgent->syncPermissions([
            'view prospects',
            'create prospects',
            'edit prospects',
            'view customers',
            'edit customers',
        ]);

        // ========= Billing Agent — clientes + facturación =========
        $billingAgent = Role::findByName('billing-agent');
        $billingAgent->syncPermissions([
            'view customers',
            'view billing',
            'edit billing',
        ]);

        // ========= Support — solo soporte =========
        $support = Role::findByName('support');
        $support->syncPermissions([
            'view support',
            'edit support',
        ]);

        $this->command->info('✅ Permissions created and assigned successfully.');
    }
}