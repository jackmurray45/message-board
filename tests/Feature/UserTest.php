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
        $response->assertStatus(500);
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
        $this->assertEquals(User::find(1)->bio, 'Test Bio'); 
        $response->assertStatus(302);
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
        $this->assertEquals(User::find(1)->bio, $user->bio);
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
        $this->assertEquals(User::find(2)->email, $user2->email);

        $response->assertStatus(302);
    }
    
}
