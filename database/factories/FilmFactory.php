<?php

use Faker\Generator as Faker;

$factory->define(App\Film::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->realText(100),
        'description'   =>  $faker->realText(500),
        'release_date'  =>  $faker->date(),
        'rating'        =>  $faker->numberBetween(1,5),
        'ticket_price'  =>  $faker->randomFloat(2, 0, 15),
        'country'       =>  $faker->country(),
        'photo'         =>  $faker->imageUrl()
    ];
});
