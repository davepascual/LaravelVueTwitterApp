<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => App\User::all()->random()->id,
        'body' => $faker->sentence(5),
        'created_at' => $faker->unique()->dateTimeBetween($startDate = "-30 days", $endDate = "now")->format('Y-m-d H:i:s')
    ];
});
