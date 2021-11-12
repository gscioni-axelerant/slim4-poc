<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__.'/../../../../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

if (empty($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "vlucas/phpdotenv" as a Composer dependency to load variables from a .env file.');
    }

    $dotenv = Dotenv::createImmutable(dirname(__DIR__).'/../../../');
    $dotenv->load();
}

if ('production' === $_ENV['APP_ENV']) {
    $containerBuilder->enableCompilation(__DIR__.'/../var/cache');
}

$settings = require 'settings.php';
$settings($containerBuilder);

$dependencies = require 'dependencies.php';
$dependencies($containerBuilder);

$repositories = require 'repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();
