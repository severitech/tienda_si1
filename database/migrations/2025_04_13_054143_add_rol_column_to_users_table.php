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
        Schema::table('users', function (Blueprint $table) {
    
            $table->foreign('ROL')
                  ->references('ROL')
                  ->on('ROL')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ROL']);
            $table->dropColumn('ROL');
        });
    }


};
