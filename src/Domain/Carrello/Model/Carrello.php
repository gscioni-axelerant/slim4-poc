<?php

declare(strict_types=1);

namespace App\Domain\Carrello\Model;

use App\Domain\Carrello\Exception\CarrelloIsEmptyException;
use App\Domain\Common\Model\DomainEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Carrello extends DomainEntity
{
    private function __construct(
        private null|UuidInterface $id,
        private Collection $prodotti
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->updatedTimestamps();
    }

    public static function crea(
        null|UuidInterface $id,
        ...$prodotti
    ): self {
        return new self($id, new ArrayCollection($prodotti));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getProdotti(): Collection
    {
        return $this->prodotti;
    }

    public function assertHasAtLeastOneProdotto(): void
    {
        if (0 === count($this->prodotti->toArray())) {
            throw new CarrelloIsEmptyException();
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'prodotti' => $this->prodotti->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
