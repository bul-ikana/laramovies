<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index () {
        return view('movie');
    }

    public function show ($slug) {
        return view('movie', ['slug' => $slug]);
    }

    public function create () {
        return view('create');
    }
}
