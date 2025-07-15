<?php
// database/migrations/2024_01_01_000022_create_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            // $table->foreignId('study_level_id')->constrained('study_levels');
            // $table->foreignId('subject_id')->constrained('subjects');
            // $table->string('school_year_id', 10);
            $table->foreignId('teaching_id')->constrained('teachings');
            $table->string('week_day', 10);
            $table->time('started_hour');
            $table->time('ended_hour');
            $table->primary(['teaching_id', 'week_day']);
            // $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};