<?php
// database/migrations/2024_01_01_000028_create_attendance_list_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_list', function (Blueprint $table) {
            // $table->foreignId('study_level_id')->constrained('study_levels');
            // $table->foreignId('subject_id')->constrained('subjects');
            // $table->foreignId('student_id')->constrained('students');
            $table->foreignId("inscription_id")->constrained("inscriptions");
            $table->foreignId("teaching_id")->constrained("teachings");
            $table->date('day');
            $table->text('observation')->nullable();
            $table->primary(['inscription_id', 'teaching_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_list');
    }
};