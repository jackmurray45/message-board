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

//Post routes
Route::apiResource('posts', 'api\PostController');

//Profile routes
Route::prefix('profiles')->group(function() {
    Route::get('me', 'api\UserController@myProfile');
    Route::put('password', 'api\UserController@updateAuthUserPassword');
    Route::post('{id}/update_photo', 'api\UserController@updatePhoto');
    Route::post('{id}/follow', 'api\UserController@followUser');
    Route::delete('{id}/follow', 'api\UserController@unfollowUser');
});
Route::apiResource('profiles', 'api\UserController');

//Comment routes
Route::get('posts/{id}/comments', 'api\CommentController@index');
Route::post('posts/{id}/comments', 'api\CommentController@store');
Route::delete('posts/{id}/comments/{comment_id}', 'api\CommentController@destroy');

//Auth routes
Route::post('/register', 'Auth\ApiAuthController@register');
Route::post('/login', 'Auth\ApiAuthController@login');
Route::post('/logout', 'Auth\ApiAuthController@logout');
Route::post('/me', 'Auth\ApiAuthController@me');

