<?php

Route::get('/', 'HomeController@home');
Route::get('/login', 'HomeController@login');

//Pages
Route::get('/pages/list', 'PageController@listPages');
Route::get('/pages/page/{id}', 'PageController@getSinglePage');

//Comments
Route::get('/comments/comment', 'CommentController@addComment');
Route::get('/comments/page', 'CommentController@getComments');
Route::get('/comments/reply', 'CommentController@replyComment');
Route::get('/comments/listreply', 'CommentController@listReplies');

//Admin
Route::get('/admin', 'AdminController@index');
