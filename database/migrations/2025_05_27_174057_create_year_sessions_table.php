<?php
// database/migrations/2024_01_01_000009_create_year_sessions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('year_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('denomination', 20);
            $table->timestamps();
        });

        DB::table('year_sessions')->insert([
            [
                "id" => "1er trimestre",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "id" => "2ème trimestre",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "id" => "3ème trimestre",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('year_sessions');
    }
};