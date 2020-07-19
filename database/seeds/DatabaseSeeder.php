<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     *
     * Seed the application's database.
     *
     * @param Faker $faker
     * @return void
     *
     */
    public function run(Faker $faker)
    {

        $this->seedUser($count = 04);               // Users table
        $this->seedPost($count = 30);               // Posts table
        $this->seedComment($count = 100);           // Comments table
        $this->seedTag($count = 20, $faker);        // Tags table
        $this->seedPostTag($count = 05, $faker);    // post_tag table
        $this->createRolePermission();              // Roles and Permission
    }

    /**
     *
     * Seeding Users table
     *
     * "Total Users Count" is given as parameter-$count
     *
     * @param $count
     *
     */
    private function seedUser($count)
    {
        factory('App\User', $count)->create();
    }

    /**
     *
     * Seeding Posts table
     *
     * Seeding through 'PostSeeder.php' file
     *
     * @param $count
     *
     */
    private function seedPost($count)
    {
        $this->call(PostSeeder::run($count));
    }

    /**
     *
     * Seeding Comment table
     *
     * Seeding through 'CommentSeeder.php' file
     *
     * @param $count
     *
     */
    private function seedComment($count)
    {
        $this->call(CommentSeeder::run($count));
    }

    /**
     *
     * Seeding Tags table
     *
     * "Total Tags count" is given as parameter-$count
     *
     * @param $count
     * @param $faker
     *
     */
    private function seedTag($count, $faker)
    {
        for ($i = 1; $i <= $count; $i++) {
            DB::table('tags')->insert([
                'name' => $faker->word,
                'created_at' => $faker->dateTimeThisYear(),
                'updated_at' => $faker->dateTimeThisYear()
            ]);
        }
    }

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
    private function seedPostTag($count, $faker)
    {
        $unique = array();  // Empty array to store the data(post_id, tag_id)
        // Loops through individual posts
        // ie, First post will get $count tags and the move to the next post
        for ($post_id = 1; $post_id <= App\Post::count(); $post_id++) {
            $loop_count = 1;        // loop_count for determining the tags per post
            while($loop_count <= $count) {
                $tag_id = $faker->numberBetween(1, App\Tag::count());
                // Checks whether the same entry is available or not
                // Executes only if there is no previous entry
                if ( !in_array([$post_id, $tag_id], $unique) ) {
                    array_push($unique, [$post_id, $tag_id]);
                    DB::table('post_tag')->insert([
                        'post_id' => $post_id,
                        'tag_id' => $tag_id
                    ]);
                    $loop_count++;
                }
            }
        }
        unset($unique);
    }

    /**
     *
     * Creating 'SuperAdmin' role
     *
     * Creating 'create-post' permission
     * Creating 'edit-post' permission
     * Creating 'delete-post' permission
     *
     * Assigning all the above permission to 'SuperAdmin role
     *
     * Assigning First User with 'SuperAdmin' role
     *
     */
    private function createRolePermission()
    {
        $role_SA = Role::create(['name' => 'SuperAdmin']);              // Create 'SuperAdmin' Role
        $role_A = Role::create(['name' => 'Admin']);                    // Create "Admin' Role

        $permission = Permission::create(['name' => 'create-post']);    // Create 'create-post' permission
        $role_SA->givePermissionTo($permission);                           // Assign 'create-post' to 'SuperAdmin'
        $role_A->givePermissionTo($permission);                           // Assign 'create-post' to 'Admin'

        $permission = Permission::create(['name' => 'edit-post']);      // Create 'edit-post' permission
        $role_SA->givePermissionTo($permission);                           // Assign 'edit-post' to 'SuperAdmin'
        $role_A->givePermissionTo($permission);                           // Assign 'edit-post' to 'Admin'

        $permission = Permission::create(['name' => 'delete-post']);    // Create 'delete-post' permission
        $role_SA->givePermissionTo($permission);                           // Assign 'delete-post' to 'SuperAdmin'
        $role_A->givePermissionTo($permission);                           // Assign 'delete-post' to 'Admin'

        App\User::first()->assignRole($role_SA);                               // Assign 'SuperAdmin' role to First User

        Role::create(['name'=>'Writer']);
        Role::create(['name'=>'Editor']);
    }
}
