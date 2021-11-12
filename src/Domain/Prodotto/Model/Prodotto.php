<?php

declare(strict_types=1);

namespace App\Domain\Prodotto\Model;

use App\Domain\Carrello\Model\Carrello;
use App\Domain\Common\Model\DomainEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Prodotto extends DomainEntity
{
    private function __construct(
        private null|UuidInterface $id,
        private Carrello $carrello,
        private string $nome,
        private float $prezzo,
        private string $sku,
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->updatedTimestamps();
    }

    public static function crea(
        null|UuidInterface $id,
        null|Carrello $carrello,
        string $nome,
        float $prezzo,
        string $sku,
    ): self {
        return new self($id, $carrello ?? Carrello::crea(id: null), $nome, $prezzo, $sku);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCarrello(): Carrello
    {
        return $this->carrello;
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
