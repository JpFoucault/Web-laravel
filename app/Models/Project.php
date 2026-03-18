<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    // Si ta table s'appelle 'projets' (vu tes colonnes en FR), précise-le ici :
    protected $table = 'projets'; 

    protected $fillable = [
        'nom_projet', 
        'description', 
        'date_debut', 
        'date_fin', 
        'budget', 
        'client_name', 
        'statut', 
        'temps_estime', 
        'technologies', 
        'collabs', 
        'createur_id'
    ];

    /**
     * Un projet possède plusieurs tickets
     */
    public function tickets(): HasMany
    {
        // On précise 'projet_id' car c'est le nom de la clé étrangère dans ta table tickets
        return $this->hasMany(Ticket::class, 'projet_id');
    }
}