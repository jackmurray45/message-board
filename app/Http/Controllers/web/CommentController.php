<?php

namespace App\Http\Controllers\web;

use Request as UrlRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Http\Resources\Comment as CommentResource;
use Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
            'content' => "required"
        ]);

        auth()->user()->comments()->create([
            'content' => $request->content,
            'post_id' => $request->post,
        ]);

        return back();
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
        if(Auth::user()->id == $comment->user_id)
        {
            $comment->delete();
        }
        return back();
    }
}
