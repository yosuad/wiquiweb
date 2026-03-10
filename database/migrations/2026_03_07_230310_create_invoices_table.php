<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contact_service_id')
                  ->constrained('contact_services')
                  ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->string('payment_link')->nullable();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->enum('status', ['pending', 'paid', 'approved', 'cancelled'])
                  ->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};