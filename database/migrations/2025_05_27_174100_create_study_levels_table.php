<?php
// database/migrations/2024_01_01_000011_create_study_levels_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('study_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_category_id')->constrained('study_categories');
            $table->text('specification');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_levels');
    }
};