<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonImage extends Model
{
    use HasFactory;

    protected $table = 'pokemon_images';

    protected $fillable = [
        'pokemon_id',
        'description',
        'url',
    ];

    public function pokemon() : BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }
}
