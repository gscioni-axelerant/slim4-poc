<?php

declare(strict_types=1);

namespace App\Domain\Carrello\Model;

use App\Domain\Carrello\Exception\CarrelloNotFoundException;
use App\Domain\Prodotto\Model\Prodotto;
use Ramsey\Uuid\UuidInterface;

interface CarrelloRepository
{
    /**
     * @return Carrello[]
     */
    public function findAll(): array;

    /**
     * @throws CarrelloNotFoundException
     */
    public function findCarrelloById(string $id): Carrello;

    public function addProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello;

    public function removeProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello;
}
