<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Application\Actions\Carrello;

use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\Model\CarrelloRepository;
use App\Domain\Prodotto\Model\Prodotto;
use App\Infrastructure\Application\Actions\ActionPayload;
use DI\Container;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ListCarrelloActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_verify_listing_carrello()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $carrello = Carrello::crea(Uuid::uuid4());
        $prodotto = Prodotto::crea(id: null, carrello: $carrello, nome: 'pippo', prezzo: 12.0, sku: 'SKU-2212');
        $carrello->getProdotti()->add($prodotto);

        $mockedCarrello = Mockery::mock(CarrelloRepository::class);
        $mockedCarrello->shouldReceive('findAll')->andReturn([$carrello]);

        $container->set(CarrelloRepository::class, $mockedCarrello);

        $request = $this->createRequest('GET', '/carrellos');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$carrello]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
