<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use App\Core\Container;
use App\Core\Router;

// Create container
$container = new Container();

// Create router with container
$router = new Router($container);
$router->loadRoutes();

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
