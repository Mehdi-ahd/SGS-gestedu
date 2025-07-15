<?php
// database/migrations/2024_01_01_000015_create_teaching_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teachings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_level_id')->constrained('study_levels');
            $table->string("group_id", 3);
            $table->foreignId('subject_id')->constrained('subjects');
            $table->string('school_year_id', 10);
            $table->foreignId('teacher_id')->constrained('users');
            // $table->primary(['study_level_id', 'subject_id', 'school_year_id']);
            $table->unique(['study_level_id', 'subject_id', 'school_year_id', 'teacher_id'], "uniq_teaching_combination");
            $table->foreign("group_id")->references("id")->on("groups");
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachings');
    }
};