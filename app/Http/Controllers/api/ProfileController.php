<?php

namespace App\Http\Controllers\api;

use Request as UrlRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $this->middleware('auth:api', ['except' => ['index', 'show']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(20);
        return ProfileResource::collection($users);
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

            return response()->json(['message' => 'User successfully followed', 'id' => $follow->id]);
        }
        else
        {
            return response()->json(['message' => 'Failed']);
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
        return new ProfileResource($user);
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
        }

        return response()->json(['message' => 'User successfully updated']);
        
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
        }
        return response()->json(['message' => 'User successfully unfollowed']);
    }

    public function myProfile()
    {
        $user = Auth::user();
        return new ProfileResource($user);
    }

    public function followingProfiles()
    {
        $followCollection = User::select('users.*', 'follows.id as follow_id')->join('follows', 'users.id', '=', 'follows.followed_user_id')
        ->where('following_user_id', '=', Auth::user()->id)->orderBy('follows.created_at', 'DESC')->paginate(20);

       
        return new ProfileResource($followCollection);
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
            return response()->json(['message' => 'Failed. Current password does not match']); 
        }

        $user->password = Hash::make($request->password);
        $user->save();
        
        return response()->json(['message' => 'Password successfully updated']);
    }
}
