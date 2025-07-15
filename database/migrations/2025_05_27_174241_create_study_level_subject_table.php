<?php
// database/migrations/2024_01_01_000014_create_study_level_subject_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('study_level_subject', function (Blueprint $table) {
            $table->foreignId('study_level_id')->constrained('study_levels');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->integer('coefficient');
            $table->primary(['study_level_id', 'subject_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_level_subject');
    }
};