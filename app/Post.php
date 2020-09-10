<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $guarded = ['id'];

    /**
    * Get user that made post
    */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
    * Get comments for post.
    */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }
}
