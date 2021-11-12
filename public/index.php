<?php

declare(strict_types=1);

use App\Infrastructure\Application\Handlers\HttpErrorHandler;
use App\Infrastructure\Application\Handlers\ShutdownHandler;
use App\Infrastructure\Application\ResponseEmitter\ResponseEmitter;
use App\Infrastructure\Application\Settings\SettingsInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Interfaces\CallableResolverInterface;

require __DIR__.'/../src/Infrastructure/Application/Core/bootstrap.php';

/** @var \Slim\App $app */
$middleware = require __DIR__.'/../src/Infrastructure/Application/Core/middleware.php';
$middleware($app);

$routes = require __DIR__.'/../src/Infrastructure/Application/Core/routes.php';
$routes($app);

/** @var \DI\Container $container */
/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();


$responseFactory = $app->getResponseFactory();
/** @var CallableResolverInterface $callableResolver */
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
