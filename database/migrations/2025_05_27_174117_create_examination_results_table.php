<?php
// database/migrations/2024_01_01_000027_create_examination_results_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examination_results', function (Blueprint $table) {
            $table->foreignId('inscription_id')->constrained('inscriptions');
            $table->foreignId('examination_id')->constrained('examinations');
            $table->integer('score');
            $table->primary(['inscription_id', 'examination_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examination_results');
    }
};