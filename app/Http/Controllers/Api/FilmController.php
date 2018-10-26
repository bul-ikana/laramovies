<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateFilmRequest;

use App\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['last_film'] = Film::with('genres')->with('comments')->latest()->first();
        $data['all_films'] = Film::orderBy('created_at', 'desc')->pluck('name', 'slug')->all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFilmRequest $request)
    {
        $film = new Film;
        $film->fill($request->all());
        $film->slug = str_slug($request->input('name'));
        if ($film->save()) {
            return response()->json($film, 201);
        } else {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = [];
        $data['last_film'] = Film::with('genres')
            ->with('comments')
            ->where('slug', $slug)
            ->first();

        $data['all_films'] = Film::orderBy('created_at', 'desc')->pluck('name', 'slug')->all();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
    }
}
