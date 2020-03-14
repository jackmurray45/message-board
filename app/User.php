<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $appends = ['is_following'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsFollowingAttribute()
    {
        return !Auth::guest() && in_array(Auth::user()->id, $this->followers()->pluck('following_user_id')->toArray());
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function followers()
    {
        return $this->hasMany('App\Follow', 'followed_user_id');
    }
    
    public function following()
    {
        return $this->hasMany('App\Follow', 'following_user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    

}
