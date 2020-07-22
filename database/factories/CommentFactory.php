<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->text(150),
        'post_id' => $faker->numberBetween(1, App\Post::count()),
        'user_name' => $faker->name(),
        'user_email' => $faker->freeEmail,
    ];
});
