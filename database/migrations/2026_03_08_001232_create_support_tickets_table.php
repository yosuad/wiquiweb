<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();

            // Client this ticket belongs to
            $table->foreignId('contact_id')
                  ->constrained('contacts')
                  ->cascadeOnDelete();

            // Agent who created the ticket
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Support agent assigned
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Ticket details
            $table->string('subject');
            $table->text('description')->nullable();

            // Status
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])
                  ->default('open');

            // Priority
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');

            // Resolution date
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};