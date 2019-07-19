<?php

use Faker\Generator as Faker;

$factory->define(App\PostReply::class, function (Faker $faker) {
    return [
        'post_id'=> App\Post::all()->random()->id,
        'user_id'=> App\User::all()->random()->id,
        'content'=> $faker->sentence(rand(10,20))
    ];
});
