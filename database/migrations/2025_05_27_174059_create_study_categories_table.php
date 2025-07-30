<?php
// database/migrations/2024_01_01_000010_create_study_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('study_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->timestamps();
        });

        DB::table('study_categories')->insert([
            [
                "name" => "Maternelle",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Primaire",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Secondaire",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('study_categories');
    }
};