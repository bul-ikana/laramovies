<?php

use Faker\Generator as Faker;

$factory->define(App\Film::class, function (Faker $faker) {
    $n = $faker->realText(100);
    return [
        'name'          =>  $n,
        'description'   =>  $faker->realText(500),
        'release_date'  =>  $faker->date(),
        'rating'        =>  $faker->numberBetween(1,5),
        'ticket_price'  =>  $faker->randomFloat(2, 0, 15),
        'country'       =>  $faker->country(),
        'photo'         =>  $faker->imageUrl(),
        'slug'          =>  str_slug($n),
    ];
});
