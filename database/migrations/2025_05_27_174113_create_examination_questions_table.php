<?php
// database/migrations/2024_01_01_000025_create_examination_questions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examination_questions', function (Blueprint $table) {
            $table->integer('id');
            $table->foreignId('examination_id')->constrained('examinations');
            $table->primary(['id', 'examination_id']);
            $table->text('question_text');
            $table->integer('points')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examination_questions');
    }
};