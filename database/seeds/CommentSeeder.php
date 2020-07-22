<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param $count
     * @return void
     */
    static public function run($count)
    {
        factory('App\Comment', $count)->create();

    }
}
