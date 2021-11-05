<?php
use Jan\Foundation\Facade\Routing\Route;
use Jan\Component\Http\Response\Response;

/*
Route::get('/', function () {
    return "Welcome!";
});

Route::get('/foo', function () {
   return new Response();
});
*/


Route::get('/foo', function () {
    /* return new Response('something to do ...');
    return [
       'id'      => 1,
       'title'   => 'Title1',
       'content' => 'Content 1...',
       'publishedAt' => date('Y-m-d')
    ];
   */

    return new Response('something to do ...');
});

Route::get('/', 'SiteController@index', 'home');
Route::map('GET|POST', '/user/register', 'SiteController@contact', 'contact');


Route::get('/posts', 'PostController@index', 'post.list');
Route::get('/post/{id}', 'PostController@show', 'post.show')
      ->where(['id' => '\d+']);




