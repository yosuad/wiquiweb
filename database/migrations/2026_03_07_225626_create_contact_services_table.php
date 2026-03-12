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

            $table->foreignId('contact_id')
                  ->constrained('contacts')
                  ->cascadeOnDelete();

            $table->foreignId('service_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Optional description to differentiate same service (e.g. two hostings)
            $table->string('description')->nullable();

            $table->foreignId('service_price_id')
                  ->constrained('service_prices')
                  ->cascadeOnDelete();

            $table->decimal('price', 10, 2);
            $table->char('currency', 3)->default('USD');
            $table->enum('billing_cycle', ['monthly', 'annual', 'one_time']);
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active');
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