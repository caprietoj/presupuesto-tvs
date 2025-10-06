<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intranet_user_id'); // ID del usuario en intranet
            $table->string('user_email')->index(); // Email del usuario (para búsqueda rápida)
            $table->string('user_name'); // Nombre del usuario (informativo)
            $table->enum('access_type', ['total', 'secciones'])->default('secciones');
            $table->json('allowed_sections')->nullable(); // Array de secciones permitidas (null = todas)
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->unique('intranet_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
