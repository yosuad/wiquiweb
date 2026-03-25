<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'   => 'fecha_inicio',
                'value' => '2021-12-02',
                'label' => 'Fecha de inicio de actividad',
            ],
            [
                'key'   => 'proyectos_realizados',
                'value' => '11',
                'label' => 'Proyectos realizados',
            ],
            // Calculados automáticamente — no se editan manualmente
            // colaborativos = proyectos * 2
            // clientes      = proyectos * 50
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'label' => $setting['label']]
            );
        }

        $this->command->info('✅ Settings seeded successfully.');
    }
}