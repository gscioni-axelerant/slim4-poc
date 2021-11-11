<?php

declare(strict_types=1);

use App\Infrastructure\Application\Handlers\HttpErrorHandler;
use App\Infrastructure\Application\Handlers\ShutdownHandler;
use App\Infrastructure\Application\ResponseEmitter\ResponseEmitter;
use App\Infrastructure\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__.'/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__.'/../var/cache');
}

// Set up settings
$settings = require __DIR__.'/../src/Infrastructure/Application/Core/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__.'/../src/Infrastructure/Application/Core/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__.'/../src/Infrastructure/Application/Core/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__.'/../src/Infrastructure/Application/Core/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__.'/../src/Infrastructure/Application/Core/routes.php';
$routes($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
