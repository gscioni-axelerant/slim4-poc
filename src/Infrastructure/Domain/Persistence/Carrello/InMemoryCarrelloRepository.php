<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Persistence\Carrello;

use App\Domain\Carrello\Exception\CarrelloNotFoundException;
use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\Model\CarrelloRepository;
use App\Domain\Prodotto\Model\Prodotto;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InMemoryCarrelloRepository implements CarrelloRepository
{
    public const UUID_1 = 'e99e906f-4ebd-4a3b-be27-cd45afb5df8d';
    /**
     * @var array<string, Carrello>
     */
    private array $carrellos;

    /**
     * @param array<Carrello> $carrellos
     */
    public function __construct(array $carrellos)
    {
        $carrello_1 = Carrello::crea(Uuid::fromString(self::UUID_1));
        $prodotto = Prodotto::crea(Uuid::uuid4(), $carrello_1, 'test', 12.0, 'SKU-7894');
        $carrello_1->getProdotti()->add($prodotto);

        $this->carrellos = $carrellos ?? [
            $carrello_1->getId()->toString() => $carrello_1,
        ];
    }

    public function findAll(): array
    {
        return array_values($this->carrellos);
    }

    public function findCarrelloById(string $id): Carrello
    {
        if (!isset($this->carrellos[$id])) {
            throw new CarrelloNotFoundException();
        }

        return $this->carrellos[$id];
    }

    public function addProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello
    {
        if (!isset($this->carrellos[$carrelloId->toString()])) {
            throw new CarrelloNotFoundException();
        }

        $this->carrellos[$carrelloId->toString()]->getProdotti()->add($prodotto);

        return $this->carrellos[$carrelloId->toString()];
    }

    public function removeProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello
    {
        if (!isset($this->carrellos[$carrelloId->toString()])) {
            throw new CarrelloNotFoundException();
        }

        $this->carrellos[$carrelloId->toString()]->getProdotti()->removeElement($prodotto);

        return $this->carrellos[$carrelloId->toString()];
    }
}
