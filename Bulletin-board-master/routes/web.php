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




Route::get('/category/{{id}}', 'PostsController@category_delete');
