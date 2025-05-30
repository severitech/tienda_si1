<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('PRODUCTO', function (Blueprint $table) {
            $table->decimal('COSTO_UNITARIO', 10, 2)->nullable()->after('PRECIO');
            $table->decimal('COSTO_PROMEDIO', 10, 2)->nullable()->after('COSTO_UNITARIO');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['COSTO_UNITARIO', 'COSTO_PROMEDIO']);
        });
    }

};
