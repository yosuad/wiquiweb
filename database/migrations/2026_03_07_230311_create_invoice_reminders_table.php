<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_reminders', function (Blueprint $table) {
            $table->id();

            // Invoice this reminder belongs to
            $table->foreignId('invoice_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Reminder number (1 = 15 days overdue, 2 = 30 days overdue)
            $table->tinyInteger('reminder_number');

            // Date and time sent
            $table->timestamp('sent_at');

            // Send status
            $table->enum('status', ['sent', 'failed'])
                  ->default('sent');

            $table->timestamps();
            $table->engine = 'InnoDB';

            // Prevents duplicate reminders
            $table->unique(['invoice_id', 'reminder_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_reminders');
    }
};