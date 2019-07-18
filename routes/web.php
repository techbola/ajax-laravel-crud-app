<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post', [
    'uses' => 'PostController@index',
    'as' => 'post.index'
]);

Route::post('addPost', [
    'uses' => 'PostController@addPost',
    'as' => 'addPost'
]);

Route::post('editPost', [
    'uses' => 'PostController@editPost',
    'as' => 'editPost'
]);

Route::post('deletePost', [
    'uses' => 'PostController@deletePost',
    'as' => 'deletePost'
]);