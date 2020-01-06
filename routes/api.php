<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('posts/following', 'api\PostController@followingPosts')->name('posts.following');
Route::resource('posts', 'api\PostController');
Route::get('profiles/following', 'api\ProfileController@followingProfiles')->name('profiles.following');
Route::get('profiles/me', 'api\ProfileController@myProfile')->name('profiles.me');
Route::post('profile/me', 'api\ProfileController@updateAuthUserPassword')->name('profiles.password');
Route::resource('profiles', 'api\ProfileController');
Route::resource('comments', 'api\CommentController');

Route::post('/register', 'Auth\ApiAuthController@register');
Route::post('/login', 'Auth\ApiAuthController@login');
Route::post('/logout', 'Auth\ApiAuthController@logout');
Route::post('/me', 'Auth\ApiAuthController@me');

