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
        Route::post('/', function() {
            $input_data = json_decode(file_get_contents('php://input'), true);
            if (isset($input_data['message'])) {
                $Message = $input_data['message'];
                $User = $Message['from'];
                if (isset($Message['text'])) $MsgText = $Message['text'];
            }

            $bot = new \app\Bot('268503234:AAFeyiEA04MRoGBIL-eEI8FVNGMdcZJTr7U');
            $text = "Добро пожаловать! Если вы хотите сделать город удобным и приятным для жизни, просто и эффективно влиять на качество городской среды, то вы зашли по адресу!" . "\r\n" .
                "Так как вы у нас в первый раз, перед тем как отправлять обращения, заполните, пожалуйста свои реквизиты, это не займёт много времени.";
            $bot->executeMethod('sendMessage', http_build_query(array('chat_id' => $User['id'], 'text' => $text, 'parse_mode' => 'HTML')));
        });
    });

});

