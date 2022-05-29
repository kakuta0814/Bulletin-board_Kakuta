<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\PostMainCategory;

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
        return view('index');
    }

    public function category()
    {
        $main_categories = \DB::table('post_main_categories')
            ->select('id', 'main_category')
            ->get();

        $sub_categories = \DB::table('post_sub_categories')
            ->select('id', 'post_main_category_id', 'sub_category')
            ->get();

        // $all_categories = \DB::table('post_sub_categories')
        //     ->select(
        //         'post_main_categories.id',
        //         'post_main_categories.main_category',
        //         'post_sub_categories.post_main_category_id',
        //         'post_sub_categories.sub_category',
        //     )
        //     ->leftjoin('post_main_categories', 'post_main_categories.id', '=', 'post_sub_categories.post_main_category_id')
        //     ->get();

        return view('category',[
            'main_categories' =>$main_categories,
            'sub_categories' =>$sub_categories,
        ]);

        // return view('category',[
        //     'all_categories' =>$all_categories,
        // ]);
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

    public function category_delete($id)
    {
        \DB::table('post_sub_categories')
            ->where('id', $id)
            ->delete();

        return redirect('/category');
    }






}
