<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follow;
Use App\Post;
use Auth;
use Hash;
use Illuminate\Support\MessageBag;

class ProfileController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']] );
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $followMap = [];
        $users = User::orderBy('created_at', 'DESC')->paginate(20);
        if(!Auth::guest())
        {
            $followCollection = Auth::user()->following;
            foreach($followCollection as $follow)
            {
                $followMap[$follow->followed_user_id] = $follow->id;
            }
        }
        
        
        return view('profile.index')->with('users', $users)->with('followMap', $followMap);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $follow = new Follow;
        $follow->following_user_id = Auth::user()->id;
        $follow->followed_user_id = $request->user;
        $follow->save();
        session()->flash('status', 'User succesfully followed!');
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
        $user = User::find($id);
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(10);
        $followId = null;
        if(!Auth::guest())
        {
            $follow = $user->followers->where('following_user_id', Auth::user()->id)->first();
            if($follow)
            {   
                $followId = $follow->id;
            }
        }
        return view('profile.show')->with('user', $user)->with('posts', $posts)->with('followId', $followId);
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
        $request->validate([
            'email' => "unique:users,email,$id,id",
            'name' => 'required|max:255'
        ]);

        $user = User::find($id);
        if($user->id === Auth::user()->id)
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->save();
            session()->flash('status', 'Your Account has been succesfully updated!');
        }
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
        $follow = Follow::find($id);
        if(isset($follow) && $follow->following_user_id === Auth::user()->id)
        {
            $follow->delete();
            session()->flash('status', 'User succesfully Unfollowed!');
        }
        return back();
    }

    public function myProfile()
    {
        $user = Auth::user();
        return view('profile.me')->with('user', $user)->with('posts', $user->posts);
    }

    public function followingProfiles()
    {

        $followCollection = User::select('users.*', 'follows.id as follow_id')->join('follows', 'users.id', '=', 'follows.followed_user_id')
        ->where('following_user_id', '=', Auth::user()->id)->orderBy('follows.created_at', 'DESC')->paginate(20);


        $followMap = [];
        foreach($followCollection as $follow)
        {
            $followMap[$follow->id] = $follow->follow_id;
        }
        return view('profile.index')->with('users', $followCollection)->with('followMap', $followMap);
    }

    public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current, $user->password)) {
            $errors = new MessageBag;
            $errors->add('password', 'Current password does not match');
            return redirect('profiles/me')->withErrors($errors);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('status', 'Password succesfully changed!');
        return back();
    }
}
