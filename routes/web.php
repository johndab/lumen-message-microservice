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
    return $router->app->version();
});

/** Messages **/
$router->get('/messages/{threadId}[/{userId}]', 'MessageController@get');
$router->post('/message/{threadId}', 'MessageController@add');

/** Threads **/
$router->get('/threads/{userId}', 'ThreadController@get');
$router->post('/thread', 'ThreadController@add');
$router->put('/thread/{threadId}[/{userId}]', 'ThreadController@update');
$router->delete('/thread/{threadId}[/{userId}]', 'ThreadController@delete');

$router->post('/thread/users/{threadId}[/{userId}]', 'ThreadController@addUsers');
$router->delete('/thread/users/{threadId}[/{userId}]', 'ThreadController@removeUsers');
