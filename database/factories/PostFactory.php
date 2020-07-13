<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'post_title' => $faker->text('100'),
        'post_description' => "<p>" . $faker->realText(15000) . "</p><p>" . $faker->realText(15000) . "</p>",
        'image' => 'images/0osO20Rc3wFG08iGbnxJaUEC3te0VcCCNZe1zqZD.jpeg',
        'user_id' => $faker->numberBetween(1,10),
    ];
});
