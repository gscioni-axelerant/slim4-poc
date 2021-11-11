<?php

declare(strict_types=1);

namespace App\Domain\Carrello\Model;

use App\Domain\Common\Traits\TimestampableModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Carrello implements \JsonSerializable
{
    use TimestampableModel;

    private Collection $prodotti;

    public function __construct(
        private null|UuidInterface $id,
        ...$prodotti
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->prodotti = new ArrayCollection($prodotti);
        $this->updatedTimestamps();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getProdotti(): Collection
    {
        return $this->prodotti;
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
