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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->enum('document_type', [
                "Carte dIdentitification Personnel",
                "Carte dIdentité Nationale",
                "Passeport",
                'CIP', 
                'Acte de naissance'
            ]);
            $table->string("document_number", 191)->nullable();
            $table->string('document_path', 100);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_documents');
    }
};
