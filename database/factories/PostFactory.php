<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'post_title' => $faker->text('100'),
        'post_description' => "<p>" . $faker->realText(1500) . "</p><p>" . $faker->realText(1500) . "</p>",
        'image' => 'seeding_images/image' . $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1,App\User::count()),
        'created_at' => $faker->dateTimeThisYear('now'),
    ];
});
