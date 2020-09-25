<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use Illuminate\Database\QueryException;


class PostTest extends TestCase
{

    use DatabaseMigrations;

    public function testCreatePostWithoutUserId()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Post::create([
            'content' => 'test post',
        ]);
    }



 
}
