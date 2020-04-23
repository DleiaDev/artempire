<?php

// No authentication required page routes
Auth::routes();
Route::view('/', 'auth.welcome')->name('welcome');

// Authentication required page routes
Route::middleware('auth')->group(function () {
  // App page routes
  Route::get('/home', 'PagesController@app')->name('home');
  Route::get('/upload', 'PagesController@app')->name('upload');
  Route::get('/account', 'PagesController@app')->name('account.edit');
  Route::get('/chat', 'PagesController@app')->name('chat');
  Route::get('/artworks/{id}', 'PagesController@app');
  Route::get('/search', 'PagesController@app')->name('search');
  Route::get('/user/{username}', 'PagesController@profile')->name('profile');

  // API account routes
  Route::put('/account/general', 'AccountController@updateGeneral');
  Route::put('/account/password', 'AccountController@changePassword');
  Route::put('/account/social', 'AccountController@updateSocialLinks');
  Route::post('/account/profile', 'AccountController@changeProfile');
  Route::post('/account/background', 'AccountController@changeBackground');

  // API follow routes
  Route::post('/api/follow/{id}', 'FollowersController@follow');
  Route::get('/api/followers/{id}', 'FollowersController@getFollowers');
  Route::get('/api/followings/{id}', 'FollowersController@getFollowings');

  // API chat routes
  Route::get('/api/chat/contacts', 'ChatController@getContacts');
  Route::get('/api/chat/contacts/{id}', 'ChatController@getContact');
  Route::get('/api/chat/contacts/{id}/messages', 'ChatController@getMessages');
  Route::post('/api/chat/seen', 'ChatController@seeMessages');
  Route::post('/api/chat/receive', 'ChatController@receiveMessage');
  Route::post('/api/chat/send', 'ChatController@sendMessage');

  // API likes routes
  Route::get('/api/user/{id}/likes', 'ArtworkController@getProfileLikes');
  Route::post('/api/artworks/{id}/like', 'ArtworkController@like');

  // API artworks routes
  Route::post('/api/artworks/{id}/comment', 'ArtworkController@comment');
  Route::delete('/api/artworks/{id}/comment', 'ArtworkController@deleteComment');
  Route::post('/api/artwork', 'ArtworkController@store');
  Route::post('/artworks/{id}/edit', 'ArtworkController@update');
  Route::delete('/api/artworks/{id}', 'ArtworkController@destroy');
  Route::get('/api/artworks/{id}', 'ArtworkController@show');

  // API home routes
  Route::get('/api/home/latest', 'HomeController@latest');
  Route::get('/api/home/following', 'HomeController@following');
});
