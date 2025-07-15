<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_study_level', function (Blueprint $table) {
            $table->string("group_id", 3);
            $table->foreignId("study_level_id")->constrained("study_levels");
            $table->foreignId("classroom_id")->nullable()->constrained("classrooms");
            $table->foreign("group_id")->references("id")->on("groups");
            $table->primary(["group_id", "study_level_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_study_level');
    }
};
