<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();

            // Relación con tabla users
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

};
