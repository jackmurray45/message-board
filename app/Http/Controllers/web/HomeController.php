<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Auth;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->limit(10)->get();
        $users = User::orderBy('created_at', 'DESC')->limit(10)->get();
        return inertia('Dashboard', [
            'posts' => $posts,
            'users' => $users
        ]);
    }
}
