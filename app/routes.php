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

$data = parse_url(Request::url());
$domain = $data['host'];
$dirpath = '';
if (isset($data['path']) && strlen($data['path']) > 0)
{
    $dirpath = isset($data['path']) ? $data['path'] : '';

    if (preg_match('/\.html\z/', $dirpath))
    {
        $dirpath = dirname($dirpath);
    }
    else
    {
        $dirpath = str_finish($dirpath, '/');
    }

    // 予約語を使っているか
    if (preg_match('{/(?:haik--[^/]+|assets|file|login|logout)/}', $dirpath))
    {
        list($dirpath) = preg_split('{/(?:haik--[^/]+|assets|file|login|logout)/}', $dirpath);
    }

    if ($dirpath === '/')
    {
        $dirpath = '';
    }
    
    if (strlen($dirpath) > 0)
    {
        $dirpath = str_finish($dirpath, '/');
    }
}

try {
    $site = Site::where('domain', $domain)->where('directory', rtrim($dirpath, '/'))->firstOrFail();
} catch (Exception $e)
{
    return Response::view('errors.missing', array(), 404);
    $site = Site::first();
}
Route::get(str_finish($dirpath. '/', '/'), array('before'=>'site', 'uses'=>'PageController@show'));

Route::when($dirpath. 'haik--admin*', 'auth');

// URL: /haik--admin/create/
Route::get($dirpath. 'haik--admin/create', 'PageController@create');
Route::post($dirpath. 'haik--admin/create', 'PageController@create');


// URL: /haik--admin/edit/{pagename}
// で edit: {pagename} を表示する
Route::get($dirpath . 'haik--admin/edit/{pagename}', 'PageController@edit');
Route::post($dirpath . 'haik--admin/edit', 'PageController@store');


// URL: /haik--admin/destroy/{pagename}
// で {pagename}を削除する

Route::get($dirpath . 'haik--admin/destroy/{pagename}', 'PageController@destroy');


Route::get($dirpath . 'haik--admin/site/settings', 'SiteController@settings');
Route::post($dirpath . 'haik--admin/site/settings', 'SiteController@store');

Route::any($dirpath . 'login', array('uses' => 'SessionController@login', 'as' => '/login'));
Route::get($dirpath . 'logout', array('uses' => 'SessionController@logout', 'as' => '/logout'));

Route::any($dirpath . 'haik--{plugin}/', 'PageController@pluginAct')
->where('plugin', '\w+');

// URL: /{pagename}
// で {pagename} を表示する

Route::get($dirpath . '{pagename}.html', 'PageController@show');
