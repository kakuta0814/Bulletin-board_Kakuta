<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\PostFavorite;

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

  public function actionLogs()
  {
    return $this->hasMany('App\Models\ActionLogs\ActionLog');
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
