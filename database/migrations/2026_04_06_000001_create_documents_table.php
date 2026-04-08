<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Le nom personnalisé donné par l'utilisateur (ex: "Rapport annuel 2025")
            $table->string('nom_document');
            // Le nom du fichier tel qu'il est sauvegardé sur le serveur (timestamp_nomoriginal)
            $table->string('nom_fichier');
            // Le statut du document
            $table->string('statut')->default('en cours');
            // L'utilisateur qui a déposé le fichier
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
