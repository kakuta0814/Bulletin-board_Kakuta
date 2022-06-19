<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Posts\Post;
use App\Models\Posts\PostFavorite;

class PostFavoritesController extends Controller
{


// // 引数のIDに紐づくリプライにLIKEする
//   public function like($id)
//   {
//     Like::create([
//       'post_id' => $id,
//       'user_id' => Auth::id(),
//     ]);

//     session()->flash('success', 'You Liked the Reply.');

//     return redirect()->back();
//   }

// // 引数のIDに紐づくリプライにUNLIKEする

//   public function unlike($id)
//   {
//     $like = Like::where('post_id', $id)->where('user_id', Auth::id())->first();
//     $like->delete();

//     session()->flash('success', 'You Unliked the Reply.');

//     return redirect()->back();
//   }

public function like_post(Request $request)
    {
         if ( $request->input('like_product') == 0) {
             //ステータスが0のときはデータベースに情報を保存
             PostFavorite::create([
                 'post_id' => $request->input('post_id'),
                  'user_id' => auth()->user()->id,
             ]);
            //ステータスが1のときはデータベースに情報を削除
         } elseif ( $request->input('like_product')  == 1 ) {
             PostFavorite::where('post_id', "=", $request->input('post_id'))
                ->where('user_id', "=", auth()->user()->id)
                ->delete();
        }
         return  $request->input('like_product');
    }

}
