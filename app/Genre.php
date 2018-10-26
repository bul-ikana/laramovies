<?php

namespace App;

use App\Film;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function films () {
        return $this->belongsToMany(Film::class);
    }
}
