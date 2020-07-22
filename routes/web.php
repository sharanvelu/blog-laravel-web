<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Searchable\Search;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//AJAX DataTables
Route::get('/index', 'PostController@index');

//Landing page
Route::get('/', function() {
    return redirect('post/home');
});

Route::group(['prefix' => 'search'], function () {
    Route::get('{key}', function ($key) {
        $searchResults_posts = (new Search())->registerModel(App\Post::class, 'post_title')
            ->search($key);
        $searchResults_tags = (new Search())->registerModel(App\Tag::class, 'name')
            ->search($key);
        return view('blog.search_result', [
            'search_key' => $key,
            'posts' => $searchResults_posts,
            'tags' => $searchResults_tags
        ]);
    });
    Route::post('date', 'PostController@BlogHomeByMonth');
});

//Blog Home and Single page
Route::group(['prefix'=>'post'], function() {
    Route::get('new', 'PostController@blogPostCreate')->name('create');
    Route::get('home', 'PostController@blogHome');
    Route::get('tag/{tag_name}', 'PostController@blogHomeTag');
    Route::get('update/{id}', 'PostController@edit');
    Route::get('{username}', 'PostController@blogHomeUser');
    Route::get('{username}/{post_url}', 'PostController@blogPost');


    Route::post('create', 'PostController@create');
    Route::post('update/{id}', 'PostController@update');
    Route::post('delete/{id}', 'PostController@delete');
});


//Route group for comment
Route::group(['prefix' => 'comment'], function () {
    Route::post('add', 'CommentController@add');
    Route::post('update/{id}', 'CommentController@update');
    Route::post('delete/{id}', 'CommentController@delete');
    Route::post('get/name', 'CommentController@getName');
});

Route::group(['prefix' => 'role'], function () {
    Route::get('list', 'RoleController@list');
    Route::get('create', 'RoleController@create');
    Route::get('assign', 'RoleController@assign');
    Route::get('update/{role_name}', 'RoleController@update');

    Route::post('add', 'RoleController@add');
    Route::post('update/{role_name}', 'RoleController@change');

    //AJAX DataTables
    Route::get('role_list', 'RoleController@roleListTable')->name('role.list');
    Route::get('user_role_list', 'RoleController@userRoleListTable')->name('user_role.list');

    //AJAX
    Route::post('delete/{role_name}', 'RoleController@deleteRole');
    Route::post('user/{action}', 'RoleController@userRoleAssignDetach');
});

//Allow or Deny new user to Register
Route::post('user/new/{action}', function ($action) {
    if ($action == 'true') $bool = 1;
    else $bool = 0;
    DB::table('user_register')
        ->updateOrInsert(
            ['id' => 1],
            ['allow_register' => $bool]);
});
