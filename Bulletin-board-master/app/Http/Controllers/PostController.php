<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\PostMainCategory;
use Carbon\Carbon;

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

        $all_posts = \DB::table('posts')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('index', [
            'all_posts'  => $all_posts,
        ]);
    }

    public function category()
    {
        // $main_categories = \DB::table('post_main_categories')
        //     ->select('id', 'main_category')
        //     ->get();

        // $sub_categories = \DB::table('post_sub_categories')
        //     ->select('id', 'post_main_category_id', 'sub_category')
        //     ->get();

        // $all_categories = \DB::table('post_sub_categories')
        //     ->select(
        //         'post_main_categories.id',
        //         'post_main_categories.main_category',
        //         'post_sub_categories.post_main_category_id',
        //         'post_sub_categories.sub_category',
        //     )
        //     ->leftjoin('post_main_categories', 'post_main_categories.id', '=', 'post_sub_categories.post_main_category_id')
        //     ->get();

            // dd ($all_categories);

        //-------------------------------------------

        $all_categories = PostMainCategory::with('postSubCategories')->get();

// $all_categories = PostSubCategory::all();




        // $all_categories = PostSubCategory::with('postMainCategories')->get();

        // dd ($all_categories);

        //-------------------------------------------

        // return view('category',[
        //     'main_categories' =>$main_categories,
        //     'sub_categories' =>$sub_categories,
        // ]);

        //-------------------------------------------

        // $all_categories = PostMainCategory::all();

        // $postSubCategories = PostSubCategory::query()
        // ->whereIn('post_main_category_id', $all_categories->pluck('id')->toArray())
        // ->get();

        // $all_categories = $all_categories->map(function (PostMainCategory $postMainCategory) use ($postSubCategories) {
        //     $subs = $postSubCategories->where('post_main_category_id', $postMainCategory->id);
        //     $postMainCategory->setAttribute('postSubCategories', $subs);
        //     return $postMainCategory;
        // });
        //-------------------------------------------

        return view('category',[
            'all_categories' =>$all_categories,
        ]);
    }

    public function category_create(Request $request)
    {
        $main_category = $request->input('main_category');
        $sub_category = $request->input('sub_category');
        $main_category_id = intval($request->input('main_category_id'));

        // dd ($sub_category);



        if (isset( $sub_category ) && isset( $main_category_id )){
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
            \DB::table('post_main_categories')->insert([
             'main_category' => $main_category
            ]);
            // 重複エラー追記
            // バリデーション追記
            return redirect('category');
        }

        if (isset( $sub_category ) && !isset( $main_category_id )){
            // エラー文
                return redirect('/category');
        }
        if (!isset( $sub_category ) && isset( $main_category_id )){
            // エラー文
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

        \DB::table('posts')->insert([
             'user_id' => Auth::id(),
             'post_sub_category_id' => $data['post_sub_category_id'],
             'title' => $data['title'],
             'post' => $data['post'],
             'event_at' => Carbon::now(),

         ]);

        return redirect('/post');
    }

    public function post_data($post_id)
    {
            $post_data = \DB::table('posts')
            ->Where('id', $post_id)
            ->first();

            $post_comments = \DB::table('post_comments')
            ->Where('post_id', $post_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('post_data', [
            'post_data' => $post_data,
            'post_comments' => $post_comments,
        ]);
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

    public function comment_create(Request $request,$post_id)
    {

        $comment_data = $request->input('comment_create');

        \DB::table('post_comments')->insert([
             'user_id' => Auth::id(),
             'post_id' => $post_id,
             'comment' => $comment_data,
             'event_at' => Carbon::now(),

         ]);

        return redirect('top');
    }






}
