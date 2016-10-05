<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);



Route::group(['middleware' => 'auth'], function() {
    Route::get('/', ['uses' => 'PostController@renderIndexPage']);
    Route::get('/posts/new', ['uses' => 'PostController@renderNewPostPage']);
    Route::get('/posts/{id}', ['uses' => 'PostController@renderOnePostPage']);
    Route::get('/ajax/comments/{id}', ['uses' => 'PostController@getCommentsByPostId']);

    Route::post('/posts', ['uses' => 'PostController@createPost']);
    Route::post('/posts/{postId}/comments', ['uses' => 'PostController@createComment']);
    Route::post('/posts/{postId}/comments/edit', ['uses' => 'PostController@updateComment']);
    Route::delete('/posts/{postId}/comments/{commentId}', ['uses' => 'PostController@deleteComment']);
    Route::post('/posts/{postId}/comments/{commentId}/up', ['uses' => 'PostController@upVoteComment']);
    Route::post('/posts/{postId}/comments/{commentId}/down', ['uses' => 'PostController@downVoteComment']);
});

Route::group(['prefix' => 'telegram'], function() {

    Route::group(['prefix' => '268503234:AAFeyiEA04MRoGBIL-eEI8FVNGMdcZJTr7U'], function() {
        Route::any('/', ['uses' => 'BotController@handle']);
    });

});

