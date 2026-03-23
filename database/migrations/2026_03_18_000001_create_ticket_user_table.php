<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // 'lecteur' = peut voir | 'editeur' = peut voir ET modifier
            $table->enum('role', ['lecteur', 'editeur'])->default('lecteur');
            $table->timestamps();

            // Un utilisateur ne peut être ajouté qu'une seule fois par ticket
            $table->unique(['ticket_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_user');
    }
};