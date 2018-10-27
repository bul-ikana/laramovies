<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateFilmRequest;
use App\Http\Requests\UpdateFilmRequest;

use App\Film;
use App\Comment;

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
        $data['last_film'] = Film::with('genres')
            ->with('comments')
            ->with('comments.user')
            ->latest()
            ->first();

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
        if ( $film->save() ) {
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
            ->with('comments.user')
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
    public function update(UpdateFilmRequest $request, $slug)
    {
        $film = Film::where('slug', $slug)->first();
        if ($film) {
            $film->fill($request->all());
            $film->slug = str_slug($request->input('name'));
            if ( $film->save() ) {
                return response()->json($film);
            } else {
                abort(500);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $film = Film::where('slug', $slug)->first();
        if ($film) {
            $film->delete();
            return response('', 204);
        } else {
            abort(404);
        }
    }

    public function comment (Request $request, $id) {
        $film = Film::find($id);

        if ($film) {
            $comment = $film->comments()->with('user')->create([
                'name'      =>  $request->input('name'),
                'comment'   =>  $request->input('comment'),
                'user_id'   =>  $request->input('user_id'),
            ]);

            $data = Comment::with('user')->find($comment->id);

            return response()->json($data, 201);
        } else {
            abort(404);
        }
    }
}
