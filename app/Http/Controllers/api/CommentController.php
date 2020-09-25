<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Comment;
use App\Post;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index($post_id)
    {

        $post = Post::FindOrFail($post_id);

        $comments = $post->comments()->orderBy('created_at', 'desc')->paginate(100);
        
        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {

        $post = Post::findOrFail($post_id);

        $request->validate([
            'content' => "required"
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $request->content
        ]);

        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return $comment;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $comment = Comment::find($id);

        if(auth()->user()->id == $comment->user_id)
        {
            $comment->delete();
        }
        else
        {
            throw new AuthorizationException();
        }
        return response(null, 204);  
    }
}
