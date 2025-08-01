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
        Schema::table('noteapp', function (Blueprint $table) {
            $table->foreign(['users_id'], 'noteapp_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noteapp', function (Blueprint $table) {
            $table->dropForeign('noteapp_ibfk_1');
        });
    }
};
