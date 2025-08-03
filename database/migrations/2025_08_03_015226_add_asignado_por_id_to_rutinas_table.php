<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rutinas', function (Blueprint $table) {
            $table->unsignedBigInteger('asignado_por_id')->nullable()->after('cliente_id');

            $table->foreign('asignado_por_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rutinas', function (Blueprint $table) {
            $table->dropForeign(['asignado_por_id']);
            $table->dropColumn('asignado_por_id');
        });
    }
};