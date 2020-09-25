<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Comment;
use App\User;
use App\Post;
use Illuminate\Database\QueryException;


class CommentTest extends TestCase
{

    use DatabaseMigrations;

    public function testCreateCommentWithoutPostId()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        $user = factory(User::class)->create();

        $result = $user->comments()->create([
            'content' => 'test comment'
        ]);

    }

    public function testCreateCommentWithoutUserId()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        $user = factory(User::class)->create();

        //Create user with post
        $user = factory(User::class)->create();
        $post = $user->posts()->save(factory(Post::class)->create());

        $result = $post->comments()->create([
            'content' => 'test comment'
        ]);

    }



 
}
