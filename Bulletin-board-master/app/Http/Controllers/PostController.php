<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\PostMainCategory;
use Carbon\Carbon;

use App\Models\Posts\Post;
use App\Models\Posts\PostFavorite;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostCommentFavorite;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $all_posts = \DB::table('posts')
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $all_posts = Post::with('user','subCategories')->withCount('postFavorite','actionLogs','comment')
        // ->with('postSubCategories')
        ->get();

        // dd ($all_posts);

        $all_categories = PostMainCategory::with('postSubCategories')->get();
        // dd ($all_categories);


        return view('index', [
            'all_posts'  => $all_posts,
            'all_categories'  => $all_categories,
        ]);
    }

    public function search(Request $request)
    {


        $search = $request->input('search');

        $all_posts = Post::with('user','subCategories')->withCount('postFavorite','actionLogs','comment')->Where('title','LIKE', "%{$search}%")->orWhere('post', 'LIKE', "%{$search}%")->get();
// dd ($all_posts);
        $all_categories = PostMainCategory::with('postSubCategories')->get();


        return view('index', [
            'all_posts'  => $all_posts,
            'all_categories'  => $all_categories,
        ]);
    }

    public function my_post()
    {


        $all_posts = Post::with('user','subCategories')->withCount('postFavorite','actionLogs','comment')
            ->where('user_id', Auth::id())->get();

// dd ($all_posts);

        $all_categories = PostMainCategory::with('postSubCategories')->get();


        return view('index', [
            'all_posts'  => $all_posts,
            'all_categories'  => $all_categories,
        ]);
    }

    public function my_like()
    {
        $like_post_id = PostFavorite::where('user_id', Auth::id())->get('post_id')->toArray();

        $all_posts = Post::with('user','subCategories','postFavorite')->withCount('postFavorite','actionLogs','comment')
        ->whereIn('id', $like_post_id)
        ->get();

// dd ($all_posts);

        $all_categories = PostMainCategory::with('postSubCategories')->get();


        return view('index', [
            'all_posts'  => $all_posts,
            'all_categories'  => $all_categories,
        ]);
    }

    public function category()
    {


        $all_categories = PostMainCategory::with('postSubCategories')->get();


        return view('category',[
            'all_categories' =>$all_categories,
        ]);
    }

    public function category_create(Request $request)
    {
        $data = $request->input();
        $main_category = $request->input('main_category');
        $sub_category = $request->input('sub_category');
        $main_category_id = intval($request->input('main_category_id'));

        // dd ($data);


        if (isset( $sub_category ) && isset( $main_category_id )){
            $validate = Validator::make($data, [
                'sub_category' => 'required|string|min:2|max:100|unique:post_sub_categories',
            ]);

            if ($validate->fails()) {
                return back()->withErrors($validate)->withInput();
            }

            \DB::table('post_sub_categories')->insert([
                // 後で修正
             'post_main_category_id' => $main_category_id,
             'sub_category' => $sub_category
            ]);
            // 重複エラー追記
            // バリデーション追記
            return redirect('category');
        }

        if (isset( $main_category )){

            $validate = Validator::make($data, [
            'main_category' => 'required|string|min:2|max:100',
            ]);

            if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
            }

            \DB::table('post_main_categories')->insert([
             'main_category' => $main_category
            ]);
            // 重複エラー追記
            // バリデーション追記
            return redirect('category');
        }

        if (isset( $sub_category ) && !isset( $main_category_id )){
            // エラー文
            $validate = Validator::make($data, [
                'main_category' => 'required|unique:post_main_categories',
                'sub_category' => 'required|string|min:2|max:100|unique:post_sub_categories',
            ]);

            if ($validate->fails()) {
                return back()->withErrors($validate)->withInput();
            }
                return redirect('/category');
        }
        if (!isset( $sub_category ) && isset( $main_category_id )){
            // エラー文
            $validate = Validator::make($data, [
                'main_category' => 'required|unique:post_main_categories',
                'sub_category' => 'required|string|min:2|max:100|unique:post_sub_categories',
            ]);

            if ($validate->fails()) {
                return back()->withErrors($validate)->withInput();
            }
                return redirect('/category');
        }

    }

    public function main_category_delete($id)
    {
        \DB::table('post_main_categories')
            ->where('id', $id)
            ->delete();

        return redirect('/category');
    }

    public function sub_category_delete($id)
    {
        \DB::table('post_sub_categories')
            ->where('id', $id)
            ->delete();

        return redirect('/category');
    }

    public function post()
    {
        $sub_categories = \DB::table('post_sub_categories')
            ->select('id', 'sub_category')
            ->get();

        return view('post',[
            'sub_categories' =>$sub_categories,
        ]);
    }

    public function post_create(Request $request)
    {
        $data = $request->input();

        $validate = Validator::make($data, [

            'post_sub_category_id' => 'required',
            'title' => 'required|string|min:2|max:100',
            'post' => 'required|string|min:2|max:5000',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        \DB::table('posts')->insert([
             'user_id' => Auth::id(),
             'post_sub_category_id' => $data['post_sub_category_id'],
             'title' => $data['title'],
             'post' => $data['post'],
             'event_at' => Carbon::now(),
         ]);

        return redirect('/top');
    }

    public function post_data($post_id)
    {
            $post = Post::with('user','subCategories')->withCount('postFavorite','actionLogs','comment')
            ->Where('id', $post_id)
            ->first();

            // $post_comments = \DB::table('post_comments')
            // ->Where('post_id', $post_id)
            // ->orderBy('created_at', 'DESC')
            // ->get();

            $post_comments = PostComment::with('user')->withCount('commentFavorite')
            ->Where('post_id', $post_id)
            ->get();


            $view_count = \DB::table('action_logs')
            ->Where('post_id', $post_id)
            ->count();

            // いいね判定
            $favorites_judge = \DB::table('post_favorites')
            ->Where('post_id', $post_id)
            ->Where('user_id', Auth::id())
            ->get();

            \DB::table('action_logs')->insert([
                'user_id' => Auth::id(),
                'post_id' => $post_id,
                'event_at' => Carbon::now(),
            ]);

// dd ($favorites_judge);


        return view('post_data', [
            'post' => $post,
            'post_comments' => $post_comments,
            'favorites_judge' => $favorites_judge,
            'view_count' => $view_count,
        ]);
    }

    public function like_post(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $review_id = $request->review_id; //2.投稿idの取得
        $already_liked = PostFavorite::where('user_id', $user_id)->where('post_id', $review_id)->first(); //3.

        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            PostFavorite::create([
                 'post_id' => $review_id,
                  'user_id' => $user_id,
             ]);
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete

            PostFavorite::where('post_id', "=", $review_id)
                ->where('user_id', "=", $user_id)
                ->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $favorites_count = \DB::table('post_favorites')
            ->Where('post_id', $review_id)
            ->count();

        $param = [
        'favorites_count' => $favorites_count,
        ];
        // $favorites_count = [
        // 'post_fav' => $post_fav,
        // ];


        return response()->json($param); //6.JSONデータをjQueryに返す
    }

    public function like_comment(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $comment_id = $request->comment_id; //2.投稿idの取得
        $already_liked = PostCommentFavorite::where('user_id', $user_id)->where('post_comment_id', $comment_id)->first(); //3.

        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            PostCommentFavorite::create([
                 'post_comment_id' => $comment_id,
                  'user_id' => $user_id,
             ]);
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete

            PostCommentFavorite::where('post_comment_id', "=", $comment_id)
                ->where('user_id', "=", $user_id)
                ->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $comment_favorite_count = \DB::table('post_comment_favorites')
            ->Where('post_comment_id', $comment_id)
            ->count();

        $param = [
        'comment_favorite_count' => $comment_favorite_count,
        ];
        // $favorites_count = [
        // 'post_fav' => $post_fav,
        // ];


        return response()->json($param); //6.JSONデータをjQueryに返す
    }



    public function comment_update_form($comment_id)
    {

        $comment_data = \DB::table('post_comments')
        ->Where('id', $comment_id)
        ->first();

        return view('comment_update', [
            'comment_data' => $comment_data,

        ]);
    }

    public function post_update_form($post_id)
    {
            $post_data = \DB::table('posts')
            ->Where('id', $post_id)
            ->first();

            $sub_categories = \DB::table('post_sub_categories')
            ->select('id', 'sub_category')
            ->get();

        return view('post_update', [
            'post_data' => $post_data,
            'sub_categories' =>$sub_categories,

        ]);
    }

    public function post_update(Request $request,$post_id)
    {

        $post = $request->input();

        $validate = Validator::make($post, [
            'post_sub_category_id' => 'required',
            'title' => 'required|string|min:1|max:100',
            'post' => 'required|string|min:1|max:5000',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        \DB::table('posts')
        ->where('id', $post_id)
        ->update([
            'post_sub_category_id' => $post['post_sub_category_id'],
            'update_user_id' => Auth::id(),
            'title' => $post['title'],
            'post' => $post['post'],
            'updated_at' => Carbon::now(),
            ]);
        // バリデーション

        return redirect('top');
    }

    public function comment_update(Request $request,$comment_id)
    {

        $comment = $request->input();

        $validate = Validator::make($comment, [
            'comment' => 'required|string|min:1|max:2500',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        \DB::table('post_comments')
        ->where('id', $comment_id)
        ->update([
            'update_user_id' => Auth::id(),
            'comment' => $comment['comment'],
            'updated_at' => Carbon::now(),
            ]);

        // リダイレクト用投稿ID取得
        $post_id = \DB::table('post_comments')
            ->Where('id', $comment_id)
            ->value('post_id');

        // バリデーション
        return redirect(route('post_data', ['post_id' => $post_id]));
    }

    public function post_delete($post_id)
    {
        \DB::table('posts')
            ->where('id', $post_id)
            ->delete();

        return redirect('top');
    }

    public function comment_delete($post_id)
    {
        \DB::table('post_comments')
            ->where('id', $post_id)
            ->delete();

        return redirect('top');
    }


    public function comment_create(Request $request,$post_id)
    {

        $comment_data = $request->input();

        $validate = Validator::make($comment_data, [
            'comment_create' => 'required|string|min:2|max:2500',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        \DB::table('post_comments')->insert([
             'user_id' => Auth::id(),
             'post_id' => $post_id,
             'comment' => $comment_data,
             'event_at' => Carbon::now(),

         ]);

        return redirect('top');
    }






}
