<?php

namespace Tests\Feature\Api;

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

    public function testCreateCommentUnAuthenticated()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->json('POST',"api/posts/$post->id/comments", [
            'content' => 'This is test content',
            'post_id' => 1
        ]);
        
        $response->assertStatus(401);
    }

    public function testCreateComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST',"api/posts/$post->id/comments", [
            'content' => 'This is test content',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Comment::count());
    }

    public function testDeleteComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create();

        $this->assertEquals(1, Comment::count());
        $response = $this->actingAs($user, 'api')->json('DELETE',"api/posts/$post->id/comments/$comment->id");

        $response->assertStatus(204);
        $this->assertEquals(0, Comment::count());
    }

    public function testFailedDeleteComment()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create();
        $user2 = factory(User::class)->create();

        $this->assertEquals(1, Comment::count());
        $response = $this->actingAs($user2, 'api')->json('DELETE',"api/posts/$post->id/comments/$comment->id");
        $response->assertStatus(403);
        $this->assertEquals(1, Comment::count());
    }


}
