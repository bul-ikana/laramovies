<?php

namespace App;

use App\Film;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function film () {
        return $this->belongsTo(Film::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }
}
