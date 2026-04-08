<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_projet',
        'client_name',
        'statut',
        'description',
        'date_debut',
        'date_fin',
        'budget',
        'temps_estime',
        'technologies',
        'createur_id',
    ];

    public function createur() {
        return $this->belongsTo(User::class, 'createur_id');
    }

    public function collaborateurs() {
        return $this->belongsToMany(User::class, 'projet_user', 'projet_id', 'user_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}