<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Clave única del setting
            $table->string('key')->unique();

            // Valor del setting
            $table->text('value')->nullable();

            // Descripción para mostrar en el panel
            $table->string('label')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};