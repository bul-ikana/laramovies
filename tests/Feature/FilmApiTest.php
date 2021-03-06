<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Film;
use App\Genre;
use App\Comment;

class FilmApiTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testIndexRouteGetsNewestFilmAnd () {
        $f1 = factory(Film::class)->create();
        sleep(1);
        $f2 = factory(Film::class)->create();
        sleep(1);
        $f3 = factory(Film::class)->create();
        $c = factory(Comment::class)->create([
            'film_id' => $f3->id
        ]);
        $g = factory(Genre::class)->create();
        $f3->genres()->attach($g);

        $response = $this->get(
            'api/films',
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment(['name'        =>  $f3->name])
            ->assertJsonFragment(['description' =>  $f3->description])
            ->assertJsonFragment(['comment'     =>  $c->comment])
            ->assertJsonFragment(['name'        =>  $g->name])
            ->assertStatus(200)
            ;
    }

    public function testIndexRouteGetsAllFilmNamesList () {
        $f1 = factory(Film::class)->create();
        $f2 = factory(Film::class)->create();
        $f3 = factory(Film::class)->create();
        $f4 = factory(Film::class)->create();

        $response = $this->get(
            'api/films',
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment([$f1->slug   =>  $f1->name])
            ->assertJsonFragment([$f2->slug   =>  $f2->name])
            ->assertJsonFragment([$f3->slug   =>  $f3->name])
            ->assertJsonFragment([$f4->slug   =>  $f4->name])
            ->assertStatus(200)
            ;
    }

    public function testShowRouteGetsMovieInformation () {
        $f1 = factory(Film::class)->create();
        $f2 = factory(Film::class)->create();
        $f3 = factory(Film::class)->create();
        $f4 = factory(Film::class)->create();

        $response = $this->get(
            'api/films/' . $f3->slug,
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment(['name'        =>  $f3->name])
            ->assertJsonFragment(['description' =>  $f3->description])
            ->assertStatus(200)
            ;
    }

    public function testShowRouteGetsAllFilmNamesList () {
        $f1 = factory(Film::class)->create();
        $f2 = factory(Film::class)->create();
        $f3 = factory(Film::class)->create();
        $f4 = factory(Film::class)->create();

        $response = $this->get(
            'api/films/' . $f3->slug,
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment([$f1->slug   =>  $f1->name])
            ->assertJsonFragment([$f2->slug   =>  $f2->name])
            ->assertJsonFragment([$f3->slug   =>  $f3->name])
            ->assertJsonFragment([$f4->slug   =>  $f4->name])
            ->assertStatus(200)
            ;
    }

    public function testCreateNewFilm () {
        $f1 = factory(Film::class)->raw();

        $response = $this->post(
            'api/films',
            $f1,
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment(['name'         =>  $f1['name']])
            ->assertJsonFragment(['description'  =>  $f1['description']])
            ->assertStatus(201)
            ;

        $this->assertDatabaseHas('films', [
            'name'         =>  $f1['name'],
            'description'  =>  $f1['description']
        ]);
    }

    public function testUpdateFilm () {
        $f1 = factory(Film::class)->create();
        $nDes = $this->faker->realText(500);
        $nRel = $this->faker->date();
        $nRat = $this->faker->numberBetween(1,5);

        $response = $this->put(
            'api/films/' . $f1->slug,
            [
                'description'   =>  $nDes,
                'release_date'  =>  $nRel,
                'rating'        =>  $nRat,
            ],
            ["Accept" => "application/json"]
        );

        $response
            ->assertJsonFragment(['description'     =>  $nDes])
            ->assertJsonFragment(['release_date'    =>  $nRel])
            ->assertJsonFragment(['rating'          =>  $nRat])
            ->assertStatus(200)
            ;

        $this->assertDatabaseHas('films', [
            'description'     =>  $nDes,
            'release_date'    =>  $nRel,
            'rating'          =>  $nRat,
        ]);
    }

    public function testDeleteFilm () {
        $f1 = factory(Film::class)->create();

        $response = $this->delete(
            'api/films/' . $f1->slug,
            ["Accept" => "application/json"]
        );

        $response->assertStatus(204);

        $this->assertDatabaseMissing('films', [
            'name'         =>  $f1['name'],
            'description'  =>  $f1['description']
        ]);
    }
}
