<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        factory('App\User', 10)->create();       //Seeding Users Table
        $this->call(PostSeeder::class);     //Seeding Posts Table
        $this->call(CommentSeeder::class);  //Seeding Comments Table\

        //Seeding tags Table
        for ($i = 0; $i < 100; $i++) {
            DB::table('tags')->insert(['name' => $faker->word,]);    //Seeding Tags table
        }

        // Seeding post_tag Table
        for ($i = 1; $i <= 20; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $temp = $faker->unique()->numberBetween(1, 101);
                DB::table('post_tag')->insert([
                    'post_id' => $i,
                    'tag_id' => $temp
                ]);
            }
        }
    }
}
