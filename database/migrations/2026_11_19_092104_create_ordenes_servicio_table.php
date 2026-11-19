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
        Schema::create('ordenes_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->restrictOnDelete();
            $table->foreignId('tecnico_id')->constrained('tecnicos')->restrictOnDelete();
            $table->string('marca_laptop', 50);
            $table->string('modelo_laptop', 80);
            $table->string('numero_serie', 60)->nullable();
            $table->dateTime('fecha_ingreso');
            $table->dateTime('fecha_entrega_estimada');
            $table->string('problema_reportado', 200);
            $table->enum('estado', ['pendiente', 'en_proceso', 'reparada', 'cancelada'])
                  ->default('pendiente');
            $table->timestamps();

            $table->index(['tecnico_id', 'fecha_ingreso']);
            $table->index(['cliente_id', 'fecha_ingreso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_servicio');
    }
};
