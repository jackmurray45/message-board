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
use App\Helpers\ImageHelper;
use App\Http\Requests\StoreUser;

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

        $users = $request->following == 1 ? 
            auth()->user()->following()->paginate(20) : 
            User::orderBy('created_at', 'DESC')->paginate(20);
                
        return inertia('Profiles', [
            'profiles' => $users,
        ]);

    }

    public function followUser($id)
    {

        auth()->user()->following()->syncWithoutDetaching($id);

        return response(null, 204);
        
    }

    public function unfollowUser($id)
    {

        auth()->user()->following()->detach($id);

        return response(null, 204);
        
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
    public function update(StoreUser $request, $id)
    {        

        User::findOrFail($id)->update($request->validated());

        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/');
    }

    public function myProfile()
    {
        return inertia('Me', [
            'user' => auth()->user()
        ]);
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
        
        $request->validate([
            'pic_option' => 'required|in:profile_pic,banner_pic',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $dbPath = ImageHelper::storeProfileImage($request->photo, $request->pic_option);
        
        $request->user()->update([$request->pic_option => "$dbPath"]);

        return redirect("profiles/{$request->user()->id}");
    }

}
