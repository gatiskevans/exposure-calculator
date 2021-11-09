<?php

use App\Twig\TwigView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

session_start();

$loader = new FilesystemLoader('app/Views');
$twigEngine = new Environment($loader);
$twigEngine->addGlobal('session', $_SESSION);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'ExposureController@index');
    $r->addRoute('POST', '/', 'ExposureController@calculateExposure');
    $r->addRoute('GET', '/history', 'ExposureController@showHistory');
    $r->addRoute('GET', '/{id}', 'ExposureController@showExposure');
    $r->addRoute('POST', '/delete/{id}', 'ExposureController@delete');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);
        $controller = "App\\Controllers\\" . $controller;
        $controller = new $controller;
        $response = $controller->$method($vars);

        if ($response instanceof TwigView) {
            echo $twigEngine->render($response->getTemplate(), $response->getVariables());
        }

        break;
}

unset($_SESSION['_errors']);
unset($_SESSION['form_data']);
unset($_SESSION['result']);
unset($_SESSION['description']);