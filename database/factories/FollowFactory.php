<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Follow;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Follow::class, function (Faker $faker) {
    $user1 = User::find(rand(1, User::count()));
    $user2 = User::find(rand(1, User::count()));
    return [
        'following_user_id' => $user1->id,
        'followed_user_id' => $user2->id
    ];
});

