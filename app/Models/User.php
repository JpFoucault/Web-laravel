<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Projet;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Tickets dont l'user est créateur
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'createur_id');
    }

    // Tickets où l'user est membre de l'équipe
    public function ticketsMembre(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // ... code existant ...
    public function projetsCrees() {
        return $this->hasMany(Projet::class, 'createur_id');
    }

    public function projetsCollab() {
        return $this->belongsToMany(Projet::class, 'projet_user');
    }
}
