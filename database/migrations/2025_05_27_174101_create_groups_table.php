<?php
// database/migrations/2024_01_01_000018_create_groups_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
};