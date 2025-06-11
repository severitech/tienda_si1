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
    Schema::create('bitacora', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // Quién hizo la acción (nullable por si no hay usuario)
        $table->string('accion'); // Ej: "Inicio de Sesión", "Creó Producto"
        $table->string('modelo_afectado')->nullable(); // Ej: App\Models\Producto
        $table->unsignedBigInteger('id_modelo_afectado')->nullable(); // Ej: 45
        $table->string('direccion_ip', 45)->nullable();
        $table->text('user_agent')->nullable(); // Información del navegador
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
