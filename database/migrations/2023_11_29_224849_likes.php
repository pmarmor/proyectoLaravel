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
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('idGame');
            $table->foreign('userId')->references('id')->on('users') ->onDelete('cascade');
            $table->foreign('idGame')->references('idGame')->on('games') ->onDelete('cascade');
            $table->unique(['userId', 'idGame'], 'noRepeat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
