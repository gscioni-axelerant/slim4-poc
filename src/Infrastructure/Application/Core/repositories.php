<?php

declare(strict_types=1);

use App\Domain\Carrello\Model\CarrelloRepository;
use App\Infrastructure\Domain\Persistence\Carrello\DoctrineCarrelloRepository;
use function DI\autowire;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CarrelloRepository::class => autowire(DoctrineCarrelloRepository::class),
    ]);
};
