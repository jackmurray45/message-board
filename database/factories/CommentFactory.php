<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use App\User;
use App\Comment;
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

$factory->define(Comment::class, function (Faker $faker) {
    $randomUserId = rand(1, User::count());
    $randomPost = Post::find(rand(1, Post::count()));
    $timestamp = $faker->dateTimeBetween($randomPost->created_at, $endDate = 'now', $timezone = 'America/Los_Angeles');
    return [
        'content' => $faker->text($maxNbChars = 1000),
        'user_id' => $randomUserId,
        'post_id' => $randomPost,
        'created_at' => $timestamp,
        'updated_at' => $timestamp
    ];
});
