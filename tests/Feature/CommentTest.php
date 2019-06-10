<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\User;
use App\Post;
use App\Comment;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    public function testCommentsRedirect()
    {
        $response = $this->post('/comments', [
            'content' => 'This is test content'
        ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testCreateComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $response = $this->actingAs($user)->post('/comments', [
            'content' => 'This is test content',
            'post' => $post
        ]);

        $this->assertEquals(Comment::count(), 1);
    }

    public function testDeleteComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create();

        $this->assertEquals(Comment::count(), 1);
        $response = $this->actingAs($user)->delete("/comments/$comment->id");
        $this->assertEquals(Comment::count(), 0);
    }

    public function testFailedDeleteComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create();
        $user2 = factory(User::class)->create();

        $this->assertEquals(Comment::count(), 1);
        $response = $this->actingAs($user2)->delete("/comments/$post->id");
        $this->assertEquals(Comment::count(), 1);
    }


}
