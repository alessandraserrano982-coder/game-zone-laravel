<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'game_id'];

    // Relación con el juego
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}