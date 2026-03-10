<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->id();

            // Service
            $table->foreignId('service_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Region
            $table->enum('region', ['colombia', 'international']);

            // Client type
            $table->enum('client_type', [
                'persona_natural',
                'empresa',
                'emprendimiento',
                'artista',
                'organizacion_social'
            ]);

            // Service type
            $table->enum('type', ['recurring', 'one_time', 'mixed'])
                  ->default('recurring');

            // Billing cycle
            $table->enum('billing_cycle', ['monthly', 'annual', 'one_time']);

            // Plan
            $table->string('plan', 150)->nullable();

            // Price
            $table->decimal('price', 10, 2);

            // Currency
            $table->char('currency', 3)->default('USD');

            $table->timestamps();
            $table->engine = 'InnoDB';

            // Prevents duplicate prices
            $table->unique(
                ['service_id', 'region', 'client_type', 'billing_cycle', 'plan'],
                'service_price_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_prices');
    }
};