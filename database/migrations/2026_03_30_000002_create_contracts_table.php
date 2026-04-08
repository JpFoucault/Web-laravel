<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            // Le nom personnalisé donné par l'utilisateur (ex: "Facture famille Guid")
            $table->string('nom_facture');
            // Le nom du fichier tel qu'il est sauvegardé sur le serveur (timestamp_nomoriginal)
            $table->string('nom_fichier');
            // L'utilisateur qui a déposé le fichier
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
