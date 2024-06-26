<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'movies';

    protected $fillable = [
        'name',
        'premiere',
        'poster',
        'active',
    ];

     /**
     * Get the places for the movie.
     */
    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class);
    }
}
