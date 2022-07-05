<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'admin_role',
    ];

    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

        public function postFavorite(){
    return $this->hasMany('App\Models\Posts\PostFavorite');
    }

    public function postCommentFavorite(){
    return $this->hasMany('App\Models\Posts\PostCommentFavorite');
    }




    public function isLikedBy($post_id): bool {
        return \App\Models\Posts\PostFavorite::where('user_id', Auth::id())->where('post_id', $post_id)->first() !==null;
    }

    public function comment_isLikedBy($comment_id): bool {
        return \App\Models\Posts\PostCommentFavorite::where('user_id', Auth::id())->where('post_comment_id', $comment_id)->first() !==null;
    }
}
