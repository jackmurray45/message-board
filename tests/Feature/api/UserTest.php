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
use App\Follow;
use App\Post;
use App\Comment;


class UserTest extends TestCase
{

    use DatabaseMigrations;

    public function testProfile()
    {
        $response = $this->get('api/profiles');
        $response->assertStatus(200);

    }

    
    public function testShowProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->get('api/profiles/1');
        $response->assertStatus(200);
    }

    
    public function testFailedShowProfile()
    {
        $response = $this->get('api/profiles/1');
        $response->assertStatus(404);
    }


    public function testMyProfileRedirect()
    {

        $response = $this->json('GET', '/api/profiles/me');
        $response->assertStatus(401);

    }

    public function testMyProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/profiles/me');
        $response->assertStatus(200);
    }

    public function testUpdateMyProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', "api/profiles/$user->id", [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => 'Test Bio'
        ]);
        $this->assertEquals('Test Bio', User::find(1)->bio); 
        $response->assertStatus(204);
    }

    public function testFailedUpdateMyProfile()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $response = $this->actingAs($user2, 'api')->json('PUT', "api/profiles/$user->id", [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user2->bio
        ]);

        $response->assertStatus(403);
        $this->assertEquals($user->bio, User::find(1)->bio);
    }

    public function testDuplicateEmails()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $response = $this->actingAs($user2, 'api')->json('PUT',"profiles/$user2->id", [
            'name' => $user2->name,
            'email' => $user1->email,
            'bio' => $user2->email
        ]);
        $response->assertStatus(422);

        //$user2's email should not have changed
        $this->assertEquals($user2->email, User::find(2)->email);

        
    }

    public function testFollow()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1, 'api')->json('POST', "api/profiles/{$user2->id}/follow");

        $response->assertStatus(204);
        $this->assertEquals(1, Follow::count());
    }

    public function testCantFollowSelf()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST',"api/profiles/{$user->id}/follow");
        
        $response->assertStatus(422);
        $this->assertEquals(0, Follow::count());
    }

    public function testDeleteFollowFail()
    {

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1, 'api')->json('POST',"api/profiles/{$user2->id}/follow");
        $response->assertStatus(204);
        $this->assertEquals(1, Follow::count());

        $response = $this->actingAs($user1, 'api')->json('DELETE',"api/profiles/1/follow");
        $response->assertStatus(422);
        $this->assertEquals(1, Follow::count());

    }

    public function testDeleteFollowPass()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1, 'api')->json('POST',"api/profiles/{$user2->id}/follow");
        $response->assertStatus(204);
        $this->assertEquals(1, Follow::count());

        $response = $this->actingAs($user1, 'api')->json('DELETE',"api/profiles/{$user2->id}/follow");
        $response->assertStatus(204);
        $this->assertEquals(0, Follow::count());
        

    }

    public function testFailedDeleteFollow()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user1, 'api')->json('POST',"api/profiles/{$user2->id}/follow");
        $response->assertStatus(204);
        $this->assertEquals(1, Follow::count());

        $response = $this->actingAs($user2, 'api')->json('DELETE',"api/profiles/{$user1->id}/follow");

        $response->assertStatus(422);
        $this->assertEquals(1, Follow::count());

    }
    
}
