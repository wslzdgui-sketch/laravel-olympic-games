<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'competitions',
        'people',
        'total_price',
    ];

    protected $casts = [
        'competitions' => 'array',
        'people' => 'array',
    ];

    public function spectators(): HasMany
    {
        return $this->hasMany(Spectator::class);
    }
}
