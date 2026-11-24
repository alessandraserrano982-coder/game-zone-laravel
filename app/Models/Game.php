<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public const GENRES = [
        'Terror / Survival',
        'Acción',
        'Aventura / Plataformas',
        'Shooter',
        'RPG / Rol',
        'Peleas',
        'Carreras / Deportes',
    ];

    protected $fillable = [
        'title',
        'genre',
        'description',
        'price',
        'image',
        'status',
        'stock',
        'release_date',
        'developer',
        'publisher',
        'minimum_requirements',
        'recommended_requirements',
        'trailer_url',
    ];
}