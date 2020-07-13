<?php

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

//Auth::loginUsingId(3);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//AJAX DataTables
Route::get('/index', 'PostController@index');

//Landing page
Route::get('/', function() {
    return redirect('post/home');
});

//Blog Home and Single page
Route::group(['prefix'=>'post'], function() {
    Route::get('test', function () {
        return view('showposts');
    });

    Route::get('new', 'PostController@blogPostCreate')->name('create');
    Route::get('home', 'PostController@blogHome');
    Route::get('tag/{tag_name}', 'PostController@blogHomeTag');
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
