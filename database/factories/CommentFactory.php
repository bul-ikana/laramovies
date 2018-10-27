<?php

use Faker\Generator as Faker;

use App\Film;
use App\User;
use App\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'film_id'   =>  function () {
                            if (Film::count()) {
                                return Film::all()->random()->id;
                            } else {
                                return factory(Film::class)->create()->id;
                            }
                        },

        'user_id'   =>  function () {
                            if (User::count()) {
                                return User::all()->random()->id;
                            } else {
                                return factory(User::class)->create()->id;
                            }
                        },
        'name'      =>  $faker->realText(50),
        'comment'   =>  $faker->realText(200),

    ];
});
