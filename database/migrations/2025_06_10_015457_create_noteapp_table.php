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
        Schema::create('noteapp', function (Blueprint $table) {
            $table->integer('notes_id', true);
            $table->string('title_note', 200);
            $table->string('notes_cotent');
            $table->string('notes_imge');
            $table->unsignedBigInteger('users_id')->index('users_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noteapp');
    }
};
