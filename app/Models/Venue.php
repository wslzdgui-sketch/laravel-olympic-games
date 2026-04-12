<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = ['name', 'capacity'];

    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class);
    }
}
