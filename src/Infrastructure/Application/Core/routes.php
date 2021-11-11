<?php

declare(strict_types=1);

use App\Infrastructure\Application\Actions\Carrello\ListCarrelloAction;
use App\Infrastructure\Application\Actions\Carrello\ViewCarrelloAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');

        return $response;
    });

    $app->group('/carrellos', function (Group $group) {
        $group->get('', ListCarrelloAction::class);
        $group->get('/{id}', ViewCarrelloAction::class);
    });
};
