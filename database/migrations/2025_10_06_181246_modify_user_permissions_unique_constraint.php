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
        Schema::table('user_permissions', function (Blueprint $table) {
            // Eliminar la restricción unique de intranet_user_id
            $table->dropUnique(['intranet_user_id']);
            
            // Agregar restricción unique a user_email en su lugar
            $table->unique('user_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_permissions', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropUnique(['user_email']);
            $table->unique('intranet_user_id');
        });
    }
};
