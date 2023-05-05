<?php

$routes = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users', 'App\Controllers\UserController@index');
    $r->addRoute('GET', '/users/{id:\d+}', 'App\Controllers\UserController@show');
    $r->addRoute('POST', '/users', 'App\Controllers\UserController@store');
    $r->addRoute('PUT', '/users/{id:\d+}', 'App\Controllers\UserController@update');
    $r->addRoute('DELETE', '/users/{id:\d+}', 'App\Controllers\UserController@destroy');
});

return $routes;