<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    // Ajoute 'project_id' ici
    protected $fillable = [
        'titre', 
        'description', 
        'type', 
        'priorite', 
        'delai', 
        'projet_id', 
        'createur_id', 
        'assigne_a_id', 
        'statut', 
        'temps_passe'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Ajoute la relation avec le projet
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
