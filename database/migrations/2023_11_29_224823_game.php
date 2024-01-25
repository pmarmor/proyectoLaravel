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
        Schema::create('games', function (Blueprint $table) {
            $table->id('idGame');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users') ->onDelete('cascade');
            $table->string('name');
            $table->string('downloadLink');
            $table->string('thumbnail');
            $table->integer('likes');
            $table->text('description')->nullable();
            $table->string('version');
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
