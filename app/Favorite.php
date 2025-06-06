<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id', 'imdb_id', 'title', 'poster', 'movie_data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}