<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Place extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'places';

    protected $fillable = [
        'place',
        'active',
    ];

    /**
     * Get the movies for the user.
     */
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
