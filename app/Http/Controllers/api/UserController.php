<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Illuminate\Validation\ValidationException;
use App\Exceptions\AuthorizationException;
use App\Helpers\ImageHelper;

class UserController extends Controller
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
        $users = !auth()->guest() && $request->following == 1 ? 
            auth()->user()->following()->paginate(20) : 
            User::orderBy('created_at', 'DESC')->paginate(20);
        
        return $users;
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
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($request->posts == 1)
        {
            $user['posts'] = $user->posts()->orderBy('created_at', 'DESC')->paginate(10);
        }

        return $user;
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

        return response(null, 204);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(auth()->user()->id == $user->id)
        {
            $user->delete();
        }
        else
        {
            throw new AuthorizationException();
        }

        return response(null, 204);
    }

    public function myProfile()
    {
        $user = auth()->user();
        return $user;
    }

    public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['the old password is incorrect.']
            ]);
            
        }

        $user->update(['password' => Hash::make($request->password)]);
        
        return response(null, 204);
    }

    public function updatePhoto(Request $request)
    {
        
        $request->validate([
            'pic_option' => 'required|in:profile_pic,banner_pic',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $dbPath = ImageHelper::storeProfileImage($request->photo, $request->pic_option);
        
        auth()->user()->update([$request->pic_option => "$dbPath"]);

        return auth()->user();
    }
}
