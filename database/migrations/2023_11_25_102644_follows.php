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
        Schema::create('follows', function (Blueprint $table) {
            $table->unsignedBigInteger('userFollows_id');
            $table->unsignedBigInteger('userFollowed_id');
            $table->foreign('userFollows_id')->references('id')->on('users') ->onDelete('cascade');
            $table->foreign('userFollowed_id')->references('id')->on('users') ->onDelete('cascade');
            $table->unique(['userFollows_id', 'userFollowed_id'], 'noRepeat');
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
