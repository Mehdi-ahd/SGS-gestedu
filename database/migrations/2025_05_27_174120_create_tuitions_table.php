<?php
// database/migrations/2024_01_01_000030_create_tuitions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tuitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_level_id')->constrained('study_levels');
            $table->foreignId('year_session_id')->constrained('year_sessions');
            $table->integer('amount');
            $table->date("payment_date");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tuitions');
    }
};