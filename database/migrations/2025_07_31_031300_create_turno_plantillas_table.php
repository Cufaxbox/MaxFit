<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('turno_plantillas', function (Blueprint $table) {
            $table->id('id_turno_plantilla');

            $table->unsignedTinyInteger('dia_semana'); // 0 = domingo, 6 = sábado
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedSmallInteger('cupo');

            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('id_actividad'); // Nueva relación

            $table->timestamps();

            // Foreign key explícita hacia users
            $table->foreign('instructor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Foreign key explícita hacia actividades
            $table->foreign('id_actividad')
                  ->references('id_actividades')
                  ->on('actividades')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turno_plantillas');
    }
};