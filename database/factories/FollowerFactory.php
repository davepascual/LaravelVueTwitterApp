<?php

use Faker\Generator as Faker;

$factory->define(App\Follower::class, function (Faker $faker) {
    return [
        'user_id' => App\User::all()->random()->id,
        'follower_id' => App\User::all()->random()->id
    ];
});
