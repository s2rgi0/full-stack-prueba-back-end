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

$router->group(['middleware'=>[], 'prefix'=> 'api/v1'], function() use ($router){
    
    $router->get('/products',['uses' => 'ProductsController@index']);
    $router->post('/products',['uses' => 'ProductsController@createProducts']);
    $router->put('/products/{id}',['uses' => 'ProductsController@updateProducts']);
    $router->delete('/products/{id}',['uses' => 'ProductsController@deleteProducts']);

    $router->get('/orden/{id}',['uses' => 'ProductsController@indexCarrito']);
    $router->post('/orden/{id}/{id_p}',['uses' => 'ProductsController@addProductsCarrito']);
    $router->delete('/orden/{id}/{id_p}',['uses' => 'ProductsController@deleteProductsCarrito']);
});
