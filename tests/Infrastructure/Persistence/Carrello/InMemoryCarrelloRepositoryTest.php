<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Carrello;

use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\ValueObject\Prodotto;
use App\Infrastructure\Domain\Persistence\Carrello\InMemoryCarrelloRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InMemoryCarrelloRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_find_all(): void
    {
        $carrello = Carrello::crea(Uuid::uuid4());

        $carrelloRepository = new InMemoryCarrelloRepository([$carrello]);

        $this->assertEquals([$carrello], $carrelloRepository->findAll());
    }
}
