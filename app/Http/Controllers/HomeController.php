<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

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
        return view('home')->with('posts', $posts)->with('users', $users);
    }
}
