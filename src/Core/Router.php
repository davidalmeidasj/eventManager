<?php

namespace App\Core;

use App\Controllers\HomeController;
use App\Controllers\EventController;

class Router
{
    private $routes = [];
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function add($route, $handler)
    {
        $this->routes[$route] = $handler;
    }

    public function loadRoutes()
    {
        $this->add('/', [HomeController::class, 'index']);
        $this->add('/list-events-formatted', [EventController::class, 'getListFormatted']);
        $this->add('/add-event', [EventController::class, 'create']);
        $this->add('/cancel-event', [EventController::class, 'cancel']);
        $this->add('/edit-event', [EventController::class, 'edit']);
        $this->add('/get-event', [EventController::class, 'getEvent']);
    }

    public function dispatch($url)
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];

        if (array_key_exists($path, $this->routes)) {
            $handler = $this->routes[$path];
            if (is_array($handler) && count($handler) === 2) {
                [$controller, $method] = $handler;
                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = $this->container->get($controller);
                    call_user_func([$controllerInstance, $method]);
                } else {
                    echo "Handler for route '{$url}' is not valid.";
                }
            } else {
                echo "Handler for route '{$url}' is not valid.";
            }
        } else {
            echo "No route found for URL '{$url}'.";
        }
    }
}
