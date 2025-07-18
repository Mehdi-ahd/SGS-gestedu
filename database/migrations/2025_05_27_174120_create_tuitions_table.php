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
            $table->foreignId('2')->constrained('study_levels');
            $table->foreignId('2')->constrained('year_sessions');
            $table->string("2", 191);
            $table->string("2",191);
            $table->integer('2');
            $table->string("2")->default("oui");
            $table->date("2");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tuitions');
    }
};