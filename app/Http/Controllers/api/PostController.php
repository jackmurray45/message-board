<?php

namespace App\Http\Controllers\api;

use Request as UrlRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Post;
use Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(20);
        return PostResource::collection($posts); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required'
        ]);

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->content = $request->content;
        $post->save();

        return response()->json(['message' => 'Post successfully sent', 'id' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if(isset($post) && $post->user_id == Auth::user()->id)
        {
            $post->delete();
        }
        return response()->json(['message' => 'Post successfully deleted']);
    }

    public function followingPosts()
    {
        $posts = Post::select('posts.*')->join('follows', 'posts.user_id', '=', 'follows.followed_user_id')
        ->where('following_user_id', '=', Auth::user()->id)->orderBy('posts.created_at', 'DESC')->paginate(20);
        return new PostResource($posts);
    }
}
