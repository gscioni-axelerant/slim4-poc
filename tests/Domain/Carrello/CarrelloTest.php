<?php

declare(strict_types=1);

namespace Tests\Domain\Carrello;

use App\Domain\Carrello\Exception\CarrelloIsEmptyException;
use App\Domain\Carrello\Model\Carrello;
use App\Domain\Prodotto\Model\Prodotto;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CarrelloTest extends TestCase
{
    /**
     * @test
     */
    public function test_carrello_has_getters(): void
    {
        $carrello = Carrello::crea(Uuid::uuid4());

        $this->assertTrue(Uuid::isValid($carrello->getId()->toString()));
        $this->assertInstanceOf(ArrayCollection::class, $carrello->getProdotti());
    }

    /**
     * @test
     */
    public function test_carrello_can_json_serialize(): void
    {
        $carrello = Carrello::crea(Uuid::uuid4());

        $this->assertIsArray($carrello->jsonSerialize());
    }

    /**
     * @test
     */
    public function test_carrello_throw_exception_if_no_prodotto(): void
    {
        $carrello = Carrello::crea(Uuid::uuid4());

        $this->expectException(CarrelloIsEmptyException::class);
        $carrello->assertHasAtLeastOneProdotto();
    }

    /**
     * @test
     */
    public function it_should_create_a_carrello_with_many_prodotto(): void
    {
        $carrello = Carrello::crea(Uuid::uuid4());
        $prodotto1 = Prodotto::crea(id: Uuid::uuid4(), carrello: $carrello, nome: 'test', prezzo: 12.0, sku: 'SKU-7894');
        $prodotto2 = Prodotto::crea(id: Uuid::uuid4(), carrello: $carrello, nome: 'test', prezzo: 12.0, sku: 'SKU-7894');

        $carrello->getProdotti()->add($prodotto1);
        $carrello->getProdotti()->add($prodotto2);

        \Lambdish\Phunctional\each(function (object $prodotto) {
            $this->assertInstanceOf(Prodotto::class, $prodotto);
            $this->assertIsString($prodotto->getSku());
            $this->assertIsString($prodotto->getNome());
            $this->assertIsFloat($prodotto->getPrezzo());
        }, $carrello->getProdotti());
    }
}
