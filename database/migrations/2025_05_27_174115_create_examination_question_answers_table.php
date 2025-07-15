<?php
// database/migrations/2024_01_01_000026_create_examination_question_answers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examination_question_answers', function (Blueprint $table) {
            $table->integer('id');
            $table->foreignId('examination_id')->constrained('examinations');
            $table->integer('question_id');
            $table->text('answer_text');
            $table->enum('is_right', ['TRUE', 'FALSE']);
            $table->primary(['id', 'examination_id', 'question_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examination_question_answers');
    }
};