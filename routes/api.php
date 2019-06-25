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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('posts/following', 'PostController@followingPosts')->name('posts.following');
Route::resource('posts', 'PostController');
Route::get('profiles/following', 'ProfileController@followingProfiles')->name('profiles.following');
Route::get('profiles/me', 'ProfileController@myProfile')->name('profiles.me');
Route::post('profile/me', 'ProfileController@updateAuthUserPassword')->name('profiles.password');
Route::resource('profiles', 'ProfileController');
Route::resource('comments', 'CommentController');

Route::post('/register', 'Auth\ApiAuthController@register');
Route::post('/login', 'Auth\ApiAuthController@login');
Route::post('/logout', 'Auth\ApiAuthController@logout');
Route::post('/me', 'Auth\ApiAuthController@me');

