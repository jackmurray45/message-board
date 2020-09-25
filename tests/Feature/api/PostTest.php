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

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function testPost()
    {
        $response = $this->json('GET','api/posts');
        $response->assertStatus(200);
    }

    public function testShowPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $response = $this->json('GET','api/posts/1');
        $response->assertStatus(200);
    }

    public function testFailedShowPost()
    {
        $response = $this->json('GET','api/posts/1');
        $response->assertStatus(404);
    }

    public function testCreatePostUnAuthenticated()
    {
        $response = $this->json('POST','/posts', [
            'content' => 'This is test content'
        ]);
        
        $response->assertStatus(401);

    }

    public function testCreatePost()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST','api/posts', [
            'content' => 'This is test content'
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Post::count());
    }

    public function testDeletePost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->assertEquals(1, Post::count());
        $response = $this->actingAs($user, 'api')->json('DELETE', "api/posts/$post->id");
        $response->assertStatus(204);
        $this->assertEquals(0, Post::count());
    }

    public function testFailedDeletePost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $user2 = factory(User::class)->create();

        $this->assertEquals(1, Post::count());
        $response = $this->actingAs($user2, 'api')->json('DELETE',"api/posts/$post->id");
        $response->assertStatus(403);
        $this->assertEquals(1, Post::count());
    }
}
