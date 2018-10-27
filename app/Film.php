<?php

namespace App;

use App\Genre;
use App\Comment;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name',
        'description',
        'release_date',
        'rating',
        'ticket_price',
        'country',
        'photo'
    ];

    public function genres () {
        return $this->belongsToMany(Genre::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }
}
