<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reserva_turnos', function (Blueprint $table) {
            $table->id('id_reserva_turno');

            $table->unsignedBigInteger('id_turno_plantilla');
            $table->unsignedBigInteger('id_usuario'); // Asumiendo que el usuario que reserva es de la tabla users

            $table->date('fecha_turno'); // Día concreto de la reserva
            $table->enum('estado', ['confirmada', 'cancelada'])->default('confirmada');
            $table->timestamp('fecha_reserva')->useCurrent(); // Cuándo se hizo la reserva

            $table->timestamps();

            // Blindaje contra duplicados
            $table->unique(['id_turno_plantilla', 'id_usuario', 'fecha_turno'], 'reserva_unica');

            // Foreign keys explícitas
            $table->foreign('id_turno_plantilla')
                  ->references('id_turno_plantilla')
                  ->on('turno_plantillas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_usuario')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_turnos');
    }
};