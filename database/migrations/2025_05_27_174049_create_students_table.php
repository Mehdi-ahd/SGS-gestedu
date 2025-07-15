<?php
// database/migrations/2024_01_01_000001_create_students_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 30);
            $table->string('firstname', 30);
            $table->date('birthday');
            $table->enum('sex', ['M', 'F']);
            $table->string('phone', 12)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string("home_address",100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};