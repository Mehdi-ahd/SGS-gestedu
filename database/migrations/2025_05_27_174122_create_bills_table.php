<?php
// database/migrations/2024_01_01_000031_create_bills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('student_id')->constrained('students');
            // $table->foreignId('study_level_id')->constrained('study_levels');
            // $table->foreignId('year_session_id')->constrained('year_sessions');
            // $table->string('school_year_id', 10);
            // $table->foreignId('accountant_id')->constrained('administrators');
            $table->foreignId("inscription_id")->constrained("inscriptions");
            $table->foreignId("tuition_id")->constrained("tuitions");
            $table->integer('amount_paid');
            $table->integer('payment_step')->default(1);
            $table->string('paid_by', 30);
            $table->string("paid_with", 100);
            $table->timestamp('paid_at')->useCurrent();
            //$table->foreign('school_year_id')->references('id')->on('school_years');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
};