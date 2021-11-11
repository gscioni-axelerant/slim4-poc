<?php

declare(strict_types=1);

namespace Tests\Domain\Carrello;

use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\ValueObject\Prodotto;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CarrelloTest extends TestCase
{
    /**
     * @test
     */
    public function test_carrello_getters(): void
    {
        $carrello = new Carrello(Uuid::uuid4(), [new Prodotto(Uuid::uuid4(), 'test', 12.0, 'SKU-7894')]);

        $this->assertTrue(Uuid::isValid($carrello->getId()->toString()));
        $this->assertInstanceOf(ArrayCollection::class, $carrello->getProdotti());
    }

    /**
     * @test
     */
    public function test_carrello_can_json_serialize(): void
    {
        $carrello = new Carrello(Uuid::uuid4(), [new Prodotto(Uuid::uuid4(), 'test', 12.0, 'SKU-7894')]);
        $this->assertIsArray($carrello->jsonSerialize());
    }

    /**
     * @test
     */
    public function it_should_create_a_carrello_with_many_prodotto(): void
    {
        $carrello = new Carrello(
            Uuid::uuid4(),
            new Prodotto(Uuid::uuid4(), 'test', 12.0, 'SKU-7894'),
            new Prodotto(Uuid::uuid4(), 'test2', 24.0, 'SKU-7895'),
        );

        \Lambdish\Phunctional\each(function (object $prodotto) {

            $this->assertInstanceOf(Prodotto::class, $prodotto);
            $this->assertIsString($prodotto->getSku());
            $this->assertIsString($prodotto->getNome());
            $this->assertIsFloat($prodotto->getPrezzo());

        }, $carrello->getProdotti());
    }
}
