<?php
// database/migrations/2024_01_01_000002_create_student_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_type', 191);
            $table->string('document_path', 100);
            $table->foreignId('student_id')->constrained('students');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_documents');
    }
};