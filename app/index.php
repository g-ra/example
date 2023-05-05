<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'');
$dotenv->load();


$db = new Illuminate\Database\Capsule\Manager;
$db->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$db->setAsGlobal();
$db->bootEloquent();


$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

require __DIR__.'/src/controllers/UserController.php';
//require __DIR__.'/src/controllers/BaseController.php';
require __DIR__.'/src/models/User.php';

$routes = require __DIR__.'/routes.php';

$routeInfo = $routes->dispatch($request->getMethod(), $request->getPathInfo());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new Symfony\Component\HttpFoundation\Response('Not found', 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $response = new Symfony\Component\HttpFoundation\Response('Method not allowed', 405, ['Allow' => implode(', ', $allowedMethods)]);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        list($class, $method) = explode('@', $handler);

        $controller = new $class(new App\Services\EmailService, new App\Services\UserService);

        $response = $controller->$method($request, ...array_values($vars));
        break;
}

$response->send();