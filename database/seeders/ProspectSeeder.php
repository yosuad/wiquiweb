<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\ProspectDetail;
use App\Models\ProspectNote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ProspectSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        // ─── Agentes ───────────────────────────────────────────────────────────
        $agents = [];

        $agentData = [
            ['name' => 'Juan Pérez',    'email' => 'juan@wiquiweb.com'],
            ['name' => 'María López',   'email' => 'maria@wiquiweb.com'],
            ['name' => 'Carlos Ruiz',   'email' => 'carlos@wiquiweb.com'],
            ['name' => 'Ana González',  'email' => 'ana@wiquiweb.com'],
            ['name' => 'Luis Martínez', 'email' => 'luis@wiquiweb.com'],
        ];

        foreach ($agentData as $data) {
            $agent = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'status'   => 'approved',
            ]);
            $agent->assignRole('sales-agent');
            $agents[] = $agent;
        }

        // ─── Servicios ─────────────────────────────────────────────────────────
        $serviceSlugs = [
            'diseno-web',
            'seo',
            'marketing-digital',
            'desarrollo-app',
            'branding',
        ];

        $services = collect($serviceSlugs)
            ->map(fn($slug) => Service::where('slug', $slug)->first())
            ->filter()
            ->values();

        // ─── Opciones aleatorias ───────────────────────────────────────────────
        $origins  = ['facebook', 'instagram', 'referido', 'web'];
        $statuses = ['nuevo'];

        $notes = [
            'Interesado en rediseño completo del sitio.',
            'Solicita cotización para e-commerce.',
            'Quiere mejorar posicionamiento en Google.',
            'Busca agencia para manejo de redes sociales.',
            'Tiene urgencia, necesita respuesta rápida.',
            'Está evaluando varias agencias.',
            'Presupuesto limitado, busca plan básico.',
            'Gran empresa, potencial cliente de alto valor.',
            'Referido por cliente actual.',
            'Interesado en paquete completo de marketing.',
            'Preguntó específicamente por precios.',
            'Ya tiene sitio web pero quiere actualizarlo.',
            'Primera vez que contrata servicios digitales.',
            'Tiene reunión programada la próxima semana.',
            'Dejó sus datos desde el formulario del sitio web.',
            'Contacto frío, requiere seguimiento cuidadoso.',
            'Dueño de PyME, muy interesado en crecer en línea.',
            'Solicitó demo antes de tomar decisión.',
            'Cliente potencial de sector salud.',
            'Viene de campaña de Facebook Ads.',
        ];

        // ─── 10 Prospectos ────────────────────────────────────────────────────
        for ($i = 1; $i <= 10; $i++) {
            $firstName   = $faker->firstName();
            $lastName    = $faker->lastName();
            $companyName = $faker->company();
            $domain      = strtolower(
                preg_replace('/[^a-zA-Z0-9]/', '', $faker->word()) . $faker->randomNumber(3)
            );

            $agent = $faker->randomElement($agents);

            $prospect = User::create([
                'name'     => "{$firstName} {$lastName}",
                'email'    => "prospect{$i}@{$domain}.com",
                'phone'    => '+52 55 ' . $faker->numerify('#### ####'),
                'company'  => $companyName,
                'status'   => $faker->randomElement(['pending', 'approved']),
                'password' => Hash::make('password'),
            ]);
            $prospect->assignRole('prospect');

            ProspectDetail::create([
                'user_id'     => $prospect->id,
                'assigned_to' => $agent->id,
                'service_id'  => $services->isNotEmpty() ? $faker->randomElement($services)->id : null,
                'origin'      => $faker->randomElement($origins),
                'status'      => $faker->randomElement($statuses),
            ]);

            // ─── 1-3 notas por prospecto ──────────────────────────────────────
            $numNotas = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numNotas; $j++) {
                ProspectNote::create([
                    'user_id'    => $prospect->id,
                    'created_by' => $agent->id,
                    'note'       => $faker->randomElement($notes),
                ]);
            }
        }

        $this->command->info('✅ 10 prospectos creados correctamente.');
    }
}