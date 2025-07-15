<?php
// database/migrations/2024_01_01_000035_update_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 50);
            $table->string('firstname', 50);
            $table->date('birthday')->nullable();
            $table->enum('sex', ['M', 'F'])->default("M");
            $table->string('email', 100)->unique();
            $table->string('phone', 12)->nullable();
            $table->string('second_phone', 12)->nullable();
            $table->string('home_address', 100)->nullable();
            $table->string('job', 30)->nullable();
            $table->string('work_address', 30)->nullable();
            $table->string("profile_picture", 191)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum("status", [
                "en attente de soumission",
                "verifié",
                "en attente de vérification"
            ])->default("en attente de soumission");
            $table->string("role_id", 30);
            $table->foreign("role_id")->references("id")->on("roles");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};