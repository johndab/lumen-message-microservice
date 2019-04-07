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
$router->get('/messages/{threadId}[/{clientId}]', 'MessageController@get');
$router->post('/message/{threadId}', 'MessageController@add');

/** Threads **/
$router->get('/threads/{clientId}', 'ThreadController@get');
$router->post('/thread', 'ThreadController@add');
$router->put('/thread/{threadId}[/{clientId}]', 'ThreadController@update');
$router->delete('/thread/{threadId}[/{clientId}]', 'ThreadController@delete');

$router->post('/thread/clients/{threadId}[/{clientId}]', 'ThreadController@addClients');
$router->delete('/thread/clients/{threadId}[/{clientId}]', 'ThreadController@removeClients');
$router->delete('/thread/disconnect/{threadId}/{clientId}', 'ThreadController@disconnectClient');
