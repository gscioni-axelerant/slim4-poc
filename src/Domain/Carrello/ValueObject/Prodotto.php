<?php

declare(strict_types=1);

namespace App\Domain\Carrello\ValueObject;

use App\Domain\Common\Traits\TimestampableModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Prodotto implements \JsonSerializable
{
    use TimestampableModel;

    public function __construct(
        private null|UuidInterface $id,
        private string $nome,
        private float $prezzo,
        private string $sku,
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->updatedTimestamps();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPrezzo(): float
    {
        return $this->prezzo;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'sku' => $this->sku,
            'prezzo' => $this->prezzo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
