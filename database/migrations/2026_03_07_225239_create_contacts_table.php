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
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Contact
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();

            // Billing
            $table->string('address')->nullable();
            $table->enum('document_type', ['national_id', 'tax_id', 'passport'])->nullable();
            $table->string('document_number', 30)->nullable();

            // Segmentation
            $table->enum('region', ['colombia', 'international'])->nullable();
            $table->enum('client_type', [
                'individual',
                'company',
                'startup',
                'artist',
                'nonprofit'
            ])->nullable();

            // Lead origin
            $table->enum('origin', ['facebook', 'instagram', 'referral', 'web'])->nullable();

            // Assigned agent
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Funnel status
            $table->enum('status', ['prospect', 'customer', 'lost'])
                  ->default('prospect');

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