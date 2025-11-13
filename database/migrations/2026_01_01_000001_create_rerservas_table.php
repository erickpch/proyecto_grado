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
        Schema::create('rerservas', function (Blueprint $table) {
            $table->id();
            $table->decimal('costo',8,2);
            $table->date('fecha');
            $table->time('hora');

            $table->foreignId('id_trabajador')->constrained('trabajadors')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_habitacion')->constrained('habitacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rerservas');
    }
};
