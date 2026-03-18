<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id(); // id int AUTO_INCREMENT
            $table->string('nom_projet', 255);
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('client_name', 255)->nullable();
            $table->string('statut', 20)->default('en_cours');
            $table->integer('temps_estime')->nullable();
            $table->text('technologies')->nullable(); // Stocké en texte/JSON
            $table->text('collabs')->nullable();      // Stocké en texte/JSON
            $table->foreignId('createur_id')->nullable()->constrained('users');
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};