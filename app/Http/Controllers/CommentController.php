<?php

namespace App\Http\Controllers;

use Request as UrlRequest;
use Illuminate\Http\Request;
use App\Comment;
use App\Http\Resources\Comment as CommentResource;
use Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        if($this->isApi = UrlRequest::segment(1) == 'api')
        {
            auth()->setDefaultDriver('api');
        }
        else
        {
            auth()->setDefaultDriver('web');
        }
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        if($this->isApi)
        {
            $comments = Comment::orderBy('created_at', 'desc')->paginate(100);
            return CommentResource::collection($comments);
        }
        else
        {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->post_id = $request->post;
        $comment->user_id = Auth::user()->id;
        $comment->save();

        if($this->isApi)
        {
            return response()->json(['message' => 'Comment successfully posted', 'id' => $comment->id]);
        }
        else
        {
            session()->flash('status', 'Comment successfully posted!');  
        } 
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->isApi)
        {
            $comment = Comment::findOrFail($id);
            return new CommentResource($comment);
        }
        else
        {
            return redirect('/');
        }
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

        $comment = Comment::find($id);
        if(Auth::user()->id == $comment->user_id)
        {
            $comment->delete();
            if($this->isApi)
            {
                return response()->json(['message' => 'Comment successfully deleted']);
            }
            else
            {
                session()->flash('status', 'Comment successfully deleted!');
            }   
        }
        return back();

    }
}
