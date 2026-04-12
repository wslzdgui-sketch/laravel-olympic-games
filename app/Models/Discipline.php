<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discipline extends Model
{
    protected $fillable = ['nom', 'titre', 'lieu', 'jour', 'heure_debut', 'heure_fin', 'prix', 'venue_id'];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
