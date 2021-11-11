<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Application\Actions\Carrello;

use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\Model\CarrelloRepository;
use App\Domain\Carrello\ValueObject\Prodotto;
use App\Infrastructure\Application\Actions\ActionPayload;
use DI\Container;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ListCarrelloActionTest extends TestCase
{
    /**
     * @test
     * #group Carrello
     */
    public function dovrebbe_verificare_listing_carrello()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $carrello = new Carrello(Uuid::uuid4(), new Prodotto(id: null, nome: 'pippo', prezzo: 12.0, sku: 'SKU-2212'));

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
