<?php

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

use App\Mail\NewUserWelcomeMail;

Auth::routes();

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follow/{user}', 'FollowController@store');

Route::post('like/add/{post}', 'LikesController@store');
Route::post('like/remove/{post}', 'LikesController@destroy');

Route::get('/', 'PostsController@index');
Route::get('/p/create', 'PostsController@create')->name('posts.create');
Route::post('/p', 'PostsController@store')->name('posts.store');
Route::get('/p/{post}', 'PostsController@show')->name('post.show');
Route::get('/p/{post}/delete', 'PostsController@delete')->name('post.delete');

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

Route::post('/comments/{post}', 'CommentsController@store')->name('comments.store');
Route::get('/comments/{comment}', 'CommentsController@delete')->name('comment.delete');

Route::get('/search', 'SearchController@index');
Route::post('/search/keyword', 'SearchController@search');
