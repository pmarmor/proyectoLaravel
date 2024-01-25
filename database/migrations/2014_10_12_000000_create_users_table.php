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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('profile_image');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('admin');
            $table->timestamp('bannedAccount')->nullable();
            $table->integer('followers')->nullable();
            $table->integer('follows')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function($table) {
        //    $table->dropColumn('paid');
        });
       // Schema::dropIfExists('users');
    }
};
