<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_services', function (Blueprint $table) {
            $table->id();

            // Contact (prospect or customer)
            $table->foreignId('contact_id')
                  ->constrained('contacts')
                  ->cascadeOnDelete();

            // Contracted service
            $table->foreignId('service_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Catalog price used to create the contract
            $table->foreignId('service_price_id')
                  ->constrained('service_prices')
                  ->cascadeOnDelete();

            // Frozen price at time of contract
            $table->decimal('price', 10, 2);

            // Currency
            $table->char('currency', 3)->default('USD');

            // Billing cycle
            $table->enum('billing_cycle', ['monthly', 'annual', 'one_time']);

            // Service status
            $table->enum('status', ['active', 'suspended', 'cancelled'])
                  ->default('active');

            // Service dates
            $table->date('started_at')->nullable();
            $table->date('ends_at')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_services');
    }
};