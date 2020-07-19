<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param $count
     * @return void
     *
     */
    static public function run($count)
    {
        factory('App\Post', $count)->create();
    }
}
