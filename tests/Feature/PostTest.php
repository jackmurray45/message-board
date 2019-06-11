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

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function testPost()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    public function testShowPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $response = $this->get('/posts/1');
        $response->assertStatus(200);
    }

    public function testFailedShowPost()
    {
        $response = $this->get('/posts/1');
        $response->assertStatus(404);
    }

    public function testPostRedirect()
    {
        $response = $this->post('/posts', [
            'content' => 'This is test content'
        ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testCreatePost()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/posts', [
            'content' => 'This is test content'
        ]);

        $response->assertRedirect('/posts');
        $this->assertEquals(Post::count(), 1);
    }

    public function testDeletePost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->assertEquals(Post::count(), 1);
        $response = $this->actingAs($user)->delete("/posts/$post->id");
        $this->assertEquals(Post::count(), 0);
    }

    public function testFailedDeletePost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $user2 = factory(User::class)->create();

        $this->assertEquals(Post::count(), 1);
        $response = $this->actingAs($user2)->delete("/posts/$post->id");
        $this->assertEquals(Post::count(), 1);
    }
}
