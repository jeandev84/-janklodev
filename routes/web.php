<?php


# Site
Route::get('/', 'SiteController@index', 'home');
Route::map('GET|POST', '/contact', 'SiteController@contact', 'contact');

# Users
Route::get( '/users', 'UserController@index', 'users.list');
Route::map('GET|POST', '/user/{id}/edit', 'UserController@edit', 'user.edit')
->where('id', '\d+');

Route::get( '/user/{id}/delete', 'UserController@remove', 'user.remove')
->where('id', '\d+');

Route::get( '/reset-users', 'UserController@reset', 'reset.users');
Route::map('GET|POST', '/user/sign-up', 'UserController@register', 'user.register')
     ->middleware(\App\Middleware\AjaxMiddleware::class);

# News
Route::get('/news', 'NewsController@index', 'news.list');
Route::get('/new/{id}', 'NewsController@show', 'news.show')
    ->where(['id' => '\d+']);

Route::map('GET|POST', '/new', 'NewsController@create', 'news.create');



# Admin
$options = [
   'prefix' => '/admin',
   'module' => 'Admin\\',
   'name'   => 'admin.',
   'middleware' => [\Jan\Foundation\Middleware\AuthenticatedMiddleware::class]
];

Route::group(function () {
    Route::get('', 'DashboardController@index', 'dashboard');
}, $options);


