<?php
// database/migrations/2024_01_01_000009_create_year_sessions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('year_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('denomination', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('year_sessions');
    }
};