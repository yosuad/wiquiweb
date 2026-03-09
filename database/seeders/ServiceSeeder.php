<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'        => 'Hosting',
                'slug'        => 'hosting',
                'description' => 'Alojamiento web para sitios y aplicaciones.',
                'type'        => 'recurrente',
            ],
            [
                'name'        => 'Dominio',
                'slug'        => 'dominio',
                'description' => 'Registro y renovación de nombre de dominio.',
                'type'        => 'recurrente',
            ],
            [
                'name'        => 'Diseño Web',
                'slug'        => 'diseno-web',
                'description' => 'Diseño y desarrollo de sitios web a medida.',
                'type'        => 'mixto',
            ],
            [
                'name'        => 'SEO',
                'slug'        => 'seo',
                'description' => 'Optimización para motores de búsqueda.',
                'type'        => 'recurrente',
            ],
            [
                'name'        => 'Marketing Digital',
                'slug'        => 'marketing-digital',
                'description' => 'Gestión de campañas y redes sociales.',
                'type'        => 'recurrente',
            ],
            [
                'name'        => 'Desarrollo de App',
                'slug'        => 'desarrollo-app',
                'description' => 'Desarrollo de aplicaciones móviles y web.',
                'type'        => 'mixto',
            ],
            [
                'name'        => 'Chatbot',
                'slug'        => 'chatbot',
                'description' => 'Implementación de chatbot para atención al cliente.',
                'type'        => 'mixto',
            ],
            [
                'name'        => 'Asesoría',
                'slug'        => 'asesoria',
                'description' => 'Consultoría y asesoría digital.',
                'type'        => 'unico',
            ],
            [
                'name'        => 'Actualización Web',
                'slug'        => 'actualizacion-web',
                'description' => 'Actualización y mantenimiento de sitios web.',
                'type'        => 'unico',
            ],
            [
                'name'        => 'Branding',
                'slug'        => 'branding',
                'description' => 'Diseño de identidad de marca.',
                'type'        => 'unico',
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }

        $this->command->info('✅ Servicios creados correctamente.');
    }
}