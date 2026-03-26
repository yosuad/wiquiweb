<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();

            // De qué página se suscribió
            $table->string('origin')->default('wiquiweb.com');

            // Estado de la suscripción
            $table->enum('status', ['active', 'unsubscribed'])->default('active');

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};