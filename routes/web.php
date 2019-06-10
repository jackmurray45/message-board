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

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('posts/following', 'PostController@followingPosts')->name('posts.following');
Route::resource('posts', 'PostController');
Route::get('profiles/following', 'ProfileController@followingProfiles')->name('profiles.following');
Route::get('profiles/me', 'ProfileController@myProfile')->name('profiles.me');
Route::post('profile/me', 'ProfileController@updateAuthUserPassword')->name('profiles.password');
Route::resource('profiles', 'ProfileController');
Route::resource('comments', 'CommentController');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
