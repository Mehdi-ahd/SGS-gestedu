<?php
// database/migrations/2024_01_01_000024_create_examinations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('study_level_id')->constrained('study_levels');
            // $table->foreignId('subject_id')->constrained('subjects');
            // $table->string('school_year_id', 10);
            //$table->foreignId('event_id')->constrained('events');
            $table->foreignId("teaching_id")->constrained("teachings");
            $table->foreignId("year_session_id")->constrained("year_sessions");
            $table->integer('duration');
            $table->string('file_path');
            $table->enum('type', ['Devoir', 'Interrogation', 'Test'])->default('Interrogation');
            //$table->foreign('school_year_id')->references('id')->on('school_years');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examinations');
    }
};