<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('nom_projet');
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('client_name')->nullable();
            $table->string('statut')->default('nouveau');
            $table->integer('temps_estime')->nullable();
            $table->text('technologies')->nullable();
            // Clé étrangère vers la table users (le créateur)
            $table->foreignId('createur_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down() { Schema::dropIfExists('projets'); }
};