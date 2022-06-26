<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'post_sub_category_id',
        'delete_user_id',
        'update_user_id',
        'title',
        'post',
        'event_at',
    ];

  public function user()
  {
      return $this->belongsTo(User::class);
  }

    public function postFavorite()
  {
    return $this->hasMany('App\Models\Posts\PostFavorite');
  }

//後でViewで使う、いいねされているかを判定するメソッド。
    public function isLikedBy($user): bool {
        return PostFavorite::where('user_id', $user->id)->where('post_id', $this->id)->first() !==null;
    }

 /**'App\Models\Posts\PostSubCategory
  * リプライにLIKEを付いているかの判定
  *
  * @return bool true:Likeがついてる false:Likeがついてない
  */

  // public function is_liked_by_auth_user()
  // {
  //   $id = Auth::id();

  //   $likers = array();
  //   foreach($this->likes as $like) {
  //     array_push($likers, $like->user_id);
  //   }

  //   if (in_array($id, $likers)) {
  //     return true;
  //   } else {
  //     return false;
  //   }
  // }
}
