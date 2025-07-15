<?php
// database/migrations/2024_01_01_000007_create_supervisor_student_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supervisor_student', function (Blueprint $table) {
            $table->foreignId('supervisor_id')->constrained('users');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('link', ['father', 'mother', 'tutor']);
            $table->primary(['supervisor_id', 'student_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supervisor_student');
    }
};