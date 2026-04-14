<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spectator extends Model
{
    protected $fillable = [
        'reservation_id',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
