<?php


namespace App\Http\Controllers;

use Faker\Generator as Faker;
use App\Post;
use App\Tag;


class TestController extends Controller
{
    /**
     *
     * Seeding post_tag table
     *
     * "Tags per Post" is given as parameter-$count
     *
     * @param $count
     * @param $faker
     *
     */
    public function seedPostTag(Faker $faker)
    {
    }
}
