<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ========= Roles =========
        Role::firstOrCreate(['name' => 'administrator']);
        Role::firstOrCreate(['name' => 'agent']);
        Role::firstOrCreate(['name' => 'sales-agent']);
        Role::firstOrCreate(['name' => 'billing-agent']);
        Role::firstOrCreate(['name' => 'support']);

        // ========= Administrator =========
        $admin = User::firstOrCreate(
            ['email' => 'soporte@wiquiweb.com'],
            [
                'name'     => 'Jose Luis',
                'password' => Hash::make('~mSs=)@DwV"tQ;z*2w'),
                'status'   => 'approved',
            ]
        );
        $admin->assignRole('administrator');

        // ========= Support =========
        $support = User::firstOrCreate(
            ['email' => 'soporte2@wiquiweb.com'],
            [
                'name'     => 'Agente Soporte',
                'password' => Hash::make('password'),
                'status'   => 'approved',
            ]
        );
        $support->assignRole('support');

        $this->command->info('✅ Users and roles created successfully.');
    }
}