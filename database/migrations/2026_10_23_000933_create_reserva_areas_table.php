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
        Schema::create('reserva_areas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_reserva');
            $table->unsignedBigInteger('id_area');    
            $table->time('hora');
            $table->integer('cantidad');            

            // Relaciones
            $table->foreign('id_reserva')->references('id')->on('rerservas')->onDelete('cascade');
            $table->foreign('id_area')->references('id')->on('area_recreativas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_areas');
    }
};
