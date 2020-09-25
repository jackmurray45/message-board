<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\User;
use App\Follow;
use App\Post;
use App\Comment;


class UserTest extends TestCase
{

    use DatabaseMigrations;

    public function testProfile()
    {
        $response = $this->get('/profiles');
        $response->assertStatus(200);

    }

    
    public function testShowProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/profiles/1');
        $response->assertStatus(200);
    }

    
    public function testFailedShowProfile()
    {
        $response = $this->get('/profiles/1');
        $response->assertStatus(404);
    }


    public function testMyProfileRedirect()
    {
        $response = $this->get('profiles/me');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

    }

    public function testMyProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('profiles/me');
        $response->assertStatus(200);
    }

    public function testUpdateMyProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->put("profiles/$user->id", [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => 'Test Bio'
        ]);
        $this->assertEquals('Test Bio', User::find(1)->bio); 
        $response->assertStatus(200);
    }

    public function testFailedUpdateMyProfile()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $response = $this->actingAs($user2)->put("profiles/$user->id", [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user2->bio
        ]);
        $this->assertEquals($user->bio, User::find(1)->bio);
    }

    public function testDuplicateEmails()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $response = $this->actingAs($user2)->put("profiles/$user2->id", [
            'name' => $user2->name,
            'email' => $user1->email,
            'bio' => $user2->email
        ]);

        //$user2's email should not have changed
        $this->assertEquals($user2->email, User::find(2)->email);

        $response->assertStatus(302);
    }

    public function testFollow()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1)->post("/profiles/{$user2->id}/follow");

        $this->assertEquals(1, Follow::count());
    }

    public function testCantFollowSelf()
    {
        $user = factory(User::class)->create();

        $response = $this->post("/profiles/{$user->id}/follow");

        $this->assertEquals(0, Follow::count());
        $response->assertRedirect('/login');
    }

    public function testDeleteFollowFail()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1)->post("/profiles/{$user2->id}/follow");

        $this->assertEquals(1, Follow::count());
        $response = $this->actingAs($user1)->delete("/profiles/1/follow");
        $this->assertEquals(1, Follow::count());

    }

    public function testDeleteFollowPass()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1)->post("/profiles/{$user2->id}/follow");

        $this->assertEquals(1, Follow::count());
        $response = $this->actingAs($user1)->delete("/profiles/{$user2->id}/follow");
        $this->assertEquals(0, Follow::count());

    }

    public function testFailedDeleteFollow()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1)->post("/profiles/{$user2->id}/follow");

        $this->assertEquals(1, Follow::count());
        $response = $this->actingAs($user2)->delete("/profiles/{$user1->id}/follow");
        $this->assertEquals(1, Follow::count());

    }
    
}
