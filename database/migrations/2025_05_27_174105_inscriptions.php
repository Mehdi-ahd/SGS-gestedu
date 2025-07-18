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
        Schema::create("inscriptions", function(Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students");
            $table->string("group_id", 5);
            $table->foreignId("study_level_id")->constrained("study_level");
            $table->string("school_year_id",10);
            $table->enum("status", [
                "en attente",
                "accepté",
                "refusé",
                "en cours",
                "achevé",
            ])->default("en attente");
            $table->integer("final_average")->nullable();
            $table->enum("verdict", [
                'passe',
                'redouble',
                'exclu',
            ])->nullable();
            $table->foreign("school_year_id")->references("id")->on("school_years");
            $table->foreign("group_id")->references("id")->on("groups");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("inscriptions");
    }
};
