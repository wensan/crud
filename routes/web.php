<?php

Route::get('/', 'HomeController@home');
Route::get('/login', 'HomeController@login');

//Pages
Route::get('/pages/list', 'PageController@listPages');
Route::get('/pages/page/{id}', 'PageController@getSinglePage');

//Comments
Route::get('/comments/comment', 'CommentController@addComment');
Route::get('/comments/page', 'CommentController@getComments');