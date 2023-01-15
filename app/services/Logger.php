<?php
declare (strict_types = 1);

namespace App\Services;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as Monolog;

// Singleton
class Logger
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Monolog('APP');
            // using stdout as a log handler to make it easier to read logs in docker
            self::$instance->pushHandler(new StreamHandler('php://stdout', Level::Info));
        }

        return self::$instance;
    }
}
