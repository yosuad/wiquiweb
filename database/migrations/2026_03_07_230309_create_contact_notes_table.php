<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_notes', function (Blueprint $table) {
            $table->id();

            // Contact the note belongs to
            $table->foreignId('contact_id')
                  ->constrained('contacts')
                  ->cascadeOnDelete();

            // Agent who wrote the note
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Note content
            $table->text('note');

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_notes');
    }
};