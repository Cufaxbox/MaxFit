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
        Schema::create('modulo_permiso_rol', function (Blueprint $table) {
            $table->id('id_modulo_permiso_rol');
            $table->foreignId('id_roles')->references('id_roles')->on('roles')->onDelete('cascade');
            $table->foreignId('id_modulos')->references('id_modulos')->on('modulos')->onDelete('cascade');
            $table->foreignId('id_permisos')->references('id_permisos')->on('permisos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulo_permiso_rol');
    }
};
