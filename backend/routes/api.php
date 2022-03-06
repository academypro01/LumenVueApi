<?php

// Version 1.0
$router->group(['prefix' => 'api/v1', 'namespace' => 'api\v1'], function () use ($router) {
    // no Middleware needed
    $router->post('register', 'UserController@register');
    $router->post('login','UserController@login');

    // Middleware needed
    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->get('post','PostController@index');
        $router->get('post/{id}', 'PostController@show');
        $router->put('post/{id}', 'PostController@update');
        $router->delete('post/{id}', 'PostController@delete');
        $router->post('post', 'PostController@store');
    });
});
