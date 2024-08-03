<?php

namespace App\Core;

use App\Services\EventServiceImpl;
use App\Validators\EventValidator;
use App\Models\EventDao;
use App\Controllers\EventController;
use App\Controllers\HomeController;

class Container
{
    private $services = [];

    public function __construct()
    {
        $this->services[EventDao::class] = function() {
            return new EventDao();
        };

        $this->services[EventValidator::class] = function() {
            return new EventValidator();
        };

        $this->services[EventServiceImpl::class] = function($container) {
            return new EventServiceImpl($container->get(EventDao::class));
        };

        $this->services[EventController::class] = function($container) {
            return new EventController(
                $container->get(EventServiceImpl::class),
                $container->get(EventValidator::class)
            );
        };

        $this->services[HomeController::class] = function() {
            return new HomeController();
        };
    }

    public function get($class)
    {
        if (isset($this->services[$class])) {
            if (is_callable($this->services[$class])) {
                return $this->services[$class]($this);
            }
            return $this->services[$class];
        }
        throw new \Exception("Services not found: $class");
    }
}
