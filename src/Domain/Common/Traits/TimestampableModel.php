<?php

declare(strict_types=1);

namespace App\Domain\Common\Traits;

use DateTimeImmutable;

trait TimestampableModel
{
    protected ?DateTimeImmutable $created_at = null;
    protected ?DateTimeImmutable $updated_at = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new DateTimeImmutable('now'));

        if (null == $this->getCreatedAt()) {
            $this->setCreatedAt(new DateTimeImmutable('now'));
        }
    }
}
