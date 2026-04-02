<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = ['nom', 'titre', 'lieu', 'jour', 'heure_debut', 'heure_fin', 'prix'];
}
