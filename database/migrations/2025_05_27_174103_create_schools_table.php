<?php
// database/migrations/2024_01_01_000016_create_schools_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('address', 20);
            $table->string('phone', 15);
            $table->string('second_phone', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schools');
    }
};