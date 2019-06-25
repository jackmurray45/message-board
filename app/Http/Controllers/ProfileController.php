<?php

namespace App\Http\Controllers;

use Request as UrlRequest;
use Illuminate\Http\Request;
use App\User;
use App\Follow;
Use App\Post;
use App\Http\Resources\Profile as ProfileResource;
use Auth;
use Hash;
use Illuminate\Support\MessageBag;

class ProfileController extends Controller
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
        
        
        return !$this->isApi ? view('profile.index')->with('users', $users)->with('followMap', $followMap)  :  ProfileResource::collection($users);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->id != $request->user && User::find($request->user))
        {
            $follow = new Follow;
            $follow->following_user_id = Auth::user()->id;
            $follow->followed_user_id = $request->user;
            $follow->save();
            if($this->isApi)
            {
                return response()->json(['message' => 'User successfully followed', 'id' => $follow->id]);
            }
            else
            {
                session()->flash('status', 'User successfully followed!');
                return back();
            }  
        }
        else
        {
            if($this->isApi)
            {
                return response()->json(['message' => 'Failed']);
            }
            else
            {
                session()->flash('status', 'Error following user');
                return back();
            } 
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
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
        return !$this->isApi ? view('profile.show')->with('user', $user)->with('posts', $posts)->with('followId', $followId) : new ProfileResource($user) ;
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

        $user = User::findOrFail($id);
        if($user->id == Auth::user()->id)
        {
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->save();
            if($this->isApi)
            {
                
                return response()->json(['message' => 'User successfully updated']);
            }
            else
            {
                session()->flash('status', 'Your Account has been successfully updated!');    
            }
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
        $follow = Follow::findOrFail($id);
        if(isset($follow) && $follow->following_user_id == Auth::user()->id)
        {
            $follow->delete();
            if($this->isApi)
            {
                return response()->json(['message' => 'User successfully unfollowed']);
            }
            else
            {
                session()->flash('status', 'User successfully Unfollowed!');   
            }  
        }
        return back();
    }

    public function myProfile()
    {
        $user = Auth::user();
        return !$this->isApi ? view('profile.me')->with('user', $user)->with('posts', $user->posts) : new ProfileResource($user);
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
        return !$this->isApi ? view('profile.index')->with('users', $followCollection)->with('followMap', $followMap) : new ProfileResource($followCollection);
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
            if($this->isApi)
            {
                return response()->json(['message' => 'Failed. Current password does not match']);
            }
            else
            {
                $errors = new MessageBag;
                $errors->add('password', 'Current password does not match');
                return redirect('profiles/me')->withErrors($errors);
            }   
        }

        $user->password = Hash::make($request->password);
        $user->save();
        if($this->isApi)
        {
            return response()->json(['message' => 'Password successfully updated']);
        }
        else
        {
            session()->flash('status', 'Password succesfully changed!'); 
        }
        return back();
    }
}
