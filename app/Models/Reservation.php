<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'total_price',
    ];

    public function spectators(): HasMany
    {
        return $this->hasMany(Spectator::class);
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
