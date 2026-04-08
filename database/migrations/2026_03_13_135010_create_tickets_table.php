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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 150);
            $table->text('description')->nullable();
            $table->enum('type', ['bug', 'feature', 'support'])->default('bug');
            $table->enum('priorite', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->date('delai')->nullable();
            $table->foreignId('projet_id')->nullable()->constrained('projets');
            $table->foreignId('createur_id')->constrained('users');
            $table->foreignId('assigne_a_id')->nullable()->constrained('users');
            $table->string('statut', 50)->default('Nouveau');
            $table->integer('temps_passe')->default(0);
            $table->timestamps(); // Pour avoir created_at et updated_at (ou utilise date_creation)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};