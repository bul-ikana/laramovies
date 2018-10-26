<?php

use Illuminate\Database\Seeder;

use App\Film;
use App\Genre;
use App\Comment;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Film::class, 3)
            ->create()
            ->each(function ($film) {
                // Genres
                if (Genre::count() > 2) {
                    $film->genres()->attach(Genre::all()->random());
                } else {
                    $film->genres()->attach(factory(Genre::class)->create());
                }

                // Comments
                $film->comments()->save(factory(Comment::class)->create());
            }
        );
    }
}
