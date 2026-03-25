<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Llamar al UserSeeder para roles y admin
        $this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\PermissionSeeder::class);
        $this->call(\Database\Seeders\SettingSeeder::class);
        // $this->call(\Database\Seeders\ServiceSeeder::class);
    }
}
