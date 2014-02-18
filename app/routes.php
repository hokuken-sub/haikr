<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'PageController@show');

Route::when('haik-admin*', 'auth');

// URL: /haik-admin/create/
Route::get('/haik-admin/create', 'PageController@create');
Route::post('/haik-admin/create', 'PageController@create');


// URL: /haik-admin/edit/{pagename}
// で edit: {pagename} を表示する
Route::get('/haik-admin/edit/{pagename}', 'PageController@edit');
Route::post('/haik-admin/edit', 'PageController@store');


// URL: /haik-admin/destroy/{pagename}
// で {pagename}を削除する

Route::get('/haik-admin/destroy/{pagename}', 'PageController@destroy');


Route::get('haik-admin/site/settings', 'SiteController@settings');
Route::post('haik-admin/site/settings', 'SiteController@store');

Route::any('/login', array('uses' => 'SessionController@login', 'as' => '/login'));
Route::get('/logout', array('uses' => 'SessionController@logout', 'as' => '/logout'));

Route::any('haik--{plugin}/', 'PageController@pluginAct')
->where('plugin', '\w+');

// URL: /{pagename}
// で {pagename} を表示する

Route::get('/{pagename}', 'PageController@show');
