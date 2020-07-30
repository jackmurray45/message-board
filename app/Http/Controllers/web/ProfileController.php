<?php

namespace App\Http\Controllers\web;

use Request as UrlRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Follow;
Use App\Post;
use App\Http\Resources\Profile as ProfileResource;
use Auth;
use Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use App\Helpers\ImageHelper;

class ProfileController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']] );
        $this->middleware('check.following', ['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->following == 1)
        {
            $users = User::select('users.*')->join('follows', 'users.id', '=', 'follows.followed_user_id')
            ->where('following_user_id', '=', Auth::user()->id)->orderBy('follows.created_at', 'DESC')->paginate(20);
            $users->put('is_following', true)->pop();
        }
        else
        {
            $users = User::orderBy('created_at', 'DESC')->paginate(20);
        }
                
        return inertia('Profiles', [
            'profiles' => $users,
        ]);

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $success = 1;

        if(Auth::user()->id != $request->user && User::find($request->user))
        {
            $follow = new Follow;
            $follow->following_user_id = Auth::user()->id;
            $follow->followed_user_id = $request->user;
            $follow->save(); 
        }
        else
        {
            $success = 0;
        }

        return response()->json(['success' => $success]);
        
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

        //return view('profile.show')->with('user', $user)->with('posts', $posts)->with('followId', $followId);
        return inertia('Profile', [
            'profile' => $user,
            'posts' => $posts,
            'followId' => $followId == null
        ]);
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
            'name' => 'required|max:255',
            "bio" => 'nullable'
        ]);

        $user = User::findOrFail($id);
        if($user->id == Auth::user()->id)
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->save();
            //session()->flash('status', 'Your Account has been successfully updated!');  
        }

        return $this->show($user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $follow = Follow::where([
            ['following_user_id', '=', Auth::user()->id],
            ['followed_user_id', '=', $id]
        ])->first();
        
        if(isset($follow) && $follow->following_user_id == Auth::user()->id)
        {
            $follow->delete();
            session()->flash('status', 'User successfully Unfollowed!'); 
        }
        return response()->json(['success' => 1]);
    }

    public function myProfile()
    {
        $user = Auth::user();
        //return view('profile.me')->with('user', $user)->with('posts', $user->posts);
        //dd($user);
        return inertia('Me', [
            'user' => $user
        ]);
        
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
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['the old password is incorrect.']
            ]);
            
        }

        $user->password = Hash::make($request->password);
        $user->save();
        //session()->flash('status', 'Password succesfully changed!'); 
        return $this->show($user->id);
    }

    public function updatePhoto(Request $request)
    {
        
        $this->validate($request, [
            'pic_option' => 'required|in:profile_pic,banner_pic',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $resizedImage = $request->pic_option == 'profile_pic' ? ImageHelper::resizeImage($request->photo, 100, 100) : ImageHelper::resizeImage($request->photo, 750, 200);

        $imageName = md5($request->photo->getClientOriginalName());

        $directoryPath = "images/{$request->pic_option}/{$request->user()->id}";

        Storage::deleteDirectory($directoryPath);
        Storage::makeDirectory($directoryPath);

        $dbPath = "$directoryPath/$imageName.png";
        $savedPath = public_path("storage/$dbPath");

        //Save image
        $resizedImage->save($savedPath);
        
        $request->user()->update([$request->pic_option => "$dbPath"]);

        return $this->show($request->user()->id);
    }

}
