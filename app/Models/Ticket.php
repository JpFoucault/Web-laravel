<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    protected $fillable = [
        'titre', 'description', 'type', 'priorite',
        'delai', 'projet_id', 'createur_id',
        'assigne_a_id', 'statut', 'temps_passe'
    ];

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    // Tous les membres de l'équipe du ticket (table pivot)
    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Vérifie si un utilisateur peut voir ce ticket
    public function estVisible(User $user): bool
    {
        if ($user->id === $this->createur_id) return true;
        return $this->membres()->where('user_id', $user->id)->exists();
    }

    // Vérifie si un utilisateur peut modifier ce ticket
    public function peutModifier(User $user): bool
    {
        if ($user->id === $this->createur_id) return true;
        return $this->membres()
                    ->where('user_id', $user->id)
                    ->wherePivot('role', 'editeur')
                    ->exists();
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function assigneA(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigne_a_id');
    }
}