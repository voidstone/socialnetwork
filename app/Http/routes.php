<?php

/*
Home
*/

Route::get('/', [
    'uses' => '\Chatty\Http\Controllers\HomeController@index',
    'as' => 'home',
]);


Route::get('/alert', function(){
    return redirect()->route('home')->with('info','You have singned up!');
});

/*
 *
 * Auth
 */

Route::get('/signup',[
    'uses' =>'\Chatty\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup',
    'middleware' => ['guest'],
]);

Route::post('/signup',[
    'uses' =>'\Chatty\Http\Controllers\AuthController@postSignup',
    'middleware' => ['guest'],
    ]);

Route::get('/signin',[
    'uses' =>'\Chatty\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest'],
]);

Route::post('/signin',[
    'uses' =>'\Chatty\Http\Controllers\AuthController@postSignin',
    'middleware' => ['guest'],
]);

Route::get('/signout',[
    'uses' =>'\Chatty\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout',
]);

//search
Route::get('/search',[
    'uses' =>'\Chatty\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);

//UserProfile
Route::get('/user/{username}', [
    'uses' =>'\Chatty\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index',
]);


Route::get('/profile/edit', [
    'uses' =>'\Chatty\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'],
]);


Route::post('/profile/edit', [
    'uses' =>'\Chatty\Http\Controllers\ProfileController@postEdit',
    'middleware' => ['auth'],
]);


/** Friends **/

Route::get('/friends', [
    'uses' =>'\Chatty\Http\Controllers\FriendController@getIndex',
    'as' => 'friend.index',
    'middleware' => ['auth'],
]);


Route::get('/friends/add/{username}', [
    'uses' =>'\Chatty\Http\Controllers\FriendController@getAdd',
    'as' => 'friend.add',
    'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
    'uses' =>'\Chatty\Http\Controllers\FriendController@getAccept',
    'as' => 'friend.accept',
    'middleware' => ['auth'],
]);

Route::post('/status', [
    'uses' =>'\Chatty\Http\Controllers\StatusController@postStatus',
    'as' => 'status.post',
    'middleware' => ['auth'],
]);