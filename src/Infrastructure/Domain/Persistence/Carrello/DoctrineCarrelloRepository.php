<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Persistence\Carrello;

use App\Domain\Carrello\Exception\CarrelloNotFoundException;
use App\Domain\Carrello\Model\Carrello;
use App\Domain\Carrello\Model\CarrelloRepository;
use App\Domain\Prodotto\Model\Prodotto;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineCarrelloRepository implements CarrelloRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManager $entity_manager
    ) {
        $this->repository = $entity_manager->getRepository(Carrello::class);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findCarrelloById(string $id): Carrello
    {
        /** @var null|Carrello $carrello */
        $carrello = $this->repository->find($id);

        if (null === $carrello) {
            throw new CarrelloNotFoundException();
        }

        return $carrello;
    }

    public function addProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello
    {
        $carrello = $this->findCarrelloById($carrelloId->toString());

        $carrello->getProdotti()->add($prodotto);

        $this->entity_manager->persist($carrello);
        $this->entity_manager->flush();

        return $carrello;
    }

    public function removeProdotto(UuidInterface $carrelloId, Prodotto $prodotto): Carrello
    {
        $carrello = $this->findCarrelloById($carrelloId->toString());

        $carrello->getProdotti()->removeElement($prodotto);

        $this->entity_manager->persist($carrello);
        $this->entity_manager->flush();

        return $carrello;
    }
}
