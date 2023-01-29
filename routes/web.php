<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $file_content = base_path('public/main.html');
    return file_get_contents($file_content);
});

$router->get('/fila', function () use ($router) {
    $file_content = base_path('public/fila.html');
    return file_get_contents($file_content);
});

$router->get('/search', 'MusicController@search');
$router->get('list-queued-musics', 'MusicController@listQueue');
$router->get('get-music-to-play', 'MusicController@getMusicToPlay');
$router->post('/queue-music', 'MusicController@queue');
$router->post('/remove-music', 'MusicController@removeMusic');