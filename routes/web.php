<?php

/** @var \Laravel\Lumen\Routing\Router $router */
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
$api_version = "v1";

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/' . $api_version, 'middleware' => 'auth:api', 'namespace' => $api_version], function() use($router) {
    $router->get('/items', 'ProductController@index');
    $router->post('/items', 'ProductController@create');
    $router->get('/items/{id}', 'ProductController@show');
    $router->put('/items/{id}', 'ProductController@update');
    $router->delete('/items/{id}', 'ProductController@destroy');
});

$router->group(['prefix' => 'api/' . $api_version, 'middleware' => 'auth:api', 'namespace' => $api_version], function() use($router) {
    $router->post('/order/create', 'OrderController@create');
    $router->get('/orders', 'OrderController@show');
    $router->put('/order/{id}', 'OrderController@proceed');
    $router->get('/scheduer', 'OrderController@scheduer');
});
