<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // Personal data
            $table->string('first_name');
            $table->string('last_name')->nullable();

            // Correo obligatorio y único:
            // es el canal de respaldo cuando el WhatsApp viene mal escrito.
            $table->string('email')->unique();

            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Contact
            // WhatsApp obligatorio y único. Se guarda en formato
            // internacional E.164 (+573205693258), normalizado por
            // Contact::normalizePhone().
            $table->string('whatsapp', 20)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('company_name')->nullable();

            // Billing
            $table->string('address')->nullable();
            $table->enum('document_type', [
                'national_id',  // CC  — Cédula de ciudadanía
                'tax_id',       // NIT — Número de identificación tributaria
                'rut',          // RUT — Registro único tributario
                'foreign_id',   // CE  — Cédula de extranjería
                'passport',     //       Passport
                'ein',          // EIN — Employer Identification Number (USA)
            ])->nullable();
            $table->string('document_number', 30)->nullable();

            // Segmentation
            $table->enum('region', ['colombia', 'international'])->nullable();
            $table->enum('client_type', [
                'persona_natural',
                'empresa',
                'emprendimiento',
                'artista',
                'organizacion_social',
            ])->nullable();

            // Lead origin
            $table->enum('origin', ['facebook', 'instagram', 'referido', 'web', 'agente', 'meta'])->nullable();

            // ← NUEVO: campaña y anuncio de Meta que trajeron al lead la primera vez.
            // Vienen del enlace del anuncio: utm_campaign={{campaign.name}}
            // y utm_content={{ad.name}}. Vacíos si el lead no llegó por un anuncio.
            $table->string('campaign')->nullable();
            $table->string('ad')->nullable();

            // Service of interest (free text)
            $table->string('service_interest')->nullable();

            // Assigned agent
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Funnel status
            $table->enum('status', ['prospect', 'customer', 'lost'])
                ->default('prospect');

            $table->enum('pipeline_stage', ['new', 'closing', 'pending_payment'])
                ->default('new');

            $table->boolean('is_active')->default(true);

            // GDPR / Ley 1581 compliance
            $table->timestamp('privacy_accepted_at')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
