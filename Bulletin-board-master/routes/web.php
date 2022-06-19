<?php
Auth::routes();


Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');

//ログイン中のページ
Route::get('/top','PostController@index');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/category', 'PostController@category');
Route::post('/category', 'PostController@category_create');

// 投稿作成
Route::get('/post','PostController@post');
Route::post('/post','PostController@post_create');

// 投稿関連
Route::get('/post/{post_id}','PostController@post_data')->name('post_data');
Route::post('/post/{post_id}','PostController@comment_create');

// 投稿関連
Route::get('/post/update/{post_id}','PostController@post_update_form')->name('post_update_form');
Route::post('/post/update/{post_id}','PostController@post_update');

// サブ・メインカテゴリ削除
Route::get('/sub/delete/{id}', 'PostController@sub_category_delete');
Route::get('/main/delete/{id}', 'PostController@main_category_delete');

// 投稿削除
Route::get('/post/delete/{post_id}','PostController@post_delete')->name('post_delete');

// コメント
Route::get('/comment/update/{comment_id}','PostController@comment_update_form')->name('comment_update_form');
Route::post('/comment/update/{comment_id}','PostController@comment_update');

Route::post('/post_like', 'PostController@like_post');

// Route::get('/post/like/{id}', 'PostFavoritesController@like')->name('post.like');
// Route::get('/post/unlike/{id}', 'PostFavoritesController@unlike')->name('post.unlike');
