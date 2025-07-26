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
        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->id('id_usuario_rol'); // clave primaria personalizada

            $table->foreignId('id_usuario')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_rol')->constrained('roles', 'id_roles')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['id_usuario', 'id_rol']); // Evita duplicados
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_rol');
    }
};
