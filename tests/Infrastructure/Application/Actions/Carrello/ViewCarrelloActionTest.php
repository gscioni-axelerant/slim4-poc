<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Application\Actions\Carrello;

use App\Domain\Carrello\Exception\CarrelloNotFoundException;
use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\Model\CarrelloRepository;
use App\Domain\Prodotto\Model\Prodotto;
use App\Infrastructure\Application\Actions\ActionError;
use App\Infrastructure\Application\Actions\ActionPayload;
use App\Infrastructure\Application\Handlers\HttpErrorHandler;
use DI\Container;
use Mockery;
use Ramsey\Uuid\Uuid;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewCarrelloActionTest extends TestCase
{
    /**
     * @test
     */
    public function test_action(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $carrello = Carrello::crea(Uuid::uuid4());
        $prodotto1 = Prodotto::crea(id: null, carrello: $carrello, nome: 'pippo', prezzo: 12.0, sku: 'SKU-2212');
        $prodotto2 = Prodotto::crea(id: null, carrello: $carrello, nome: 'pluto', prezzo: 13.0, sku: 'SKU-2232');
        $carrello->getProdotti()->add($prodotto1);
        $carrello->getProdotti()->add($prodotto2);

        $mockedCarrello = Mockery::mock(CarrelloRepository::class);
        $mockedCarrello->shouldReceive('findCarrelloById')
            ->withArgs([(string) $carrello->getId()])
            ->andReturn($carrello);

        $container->set(CarrelloRepository::class, $mockedCarrello);

        $request = $this->createRequest('GET', sprintf('/carrellos/%s', $carrello->getId()->toString()));
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $carrello);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    /**
     * @test
     */
    public function test_action_throws_carrello_not_found_exception()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $mockedCarrello = Mockery::mock(CarrelloRepository::class);
        $mockedCarrello->shouldReceive('findCarrelloById')
            ->with('523aff1a-d4c8-424d-95bd-f8f65ee39805')
            ->once()
            ->andThrow(CarrelloNotFoundException::class, 'Il carrello che hai richiesto non esiste.');

        $container->set(CarrelloRepository::class, $mockedCarrello);

        $request = $this->createRequest('GET', '/carrellos/523aff1a-d4c8-424d-95bd-f8f65ee39805');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'Il carrello che hai richiesto non esiste.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
