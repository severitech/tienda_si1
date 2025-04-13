<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ROL', function (Blueprint $table) {
            $table->string('ROL', 255)->primary();
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
        // Insertar roles por defecto
        DB::table('ROL')->insert([
            [
                'ROL' => 'cliente',
            ],
            [
                'ROL' => 'vendedor',
            ],
            [
                'ROL' => 'administrador',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ROL');

    }
};
