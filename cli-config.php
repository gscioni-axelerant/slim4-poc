<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/src/Infrastructure/Application/Core/bootstrap.php';

return ConsoleRunner::createHelperSet(/** @var \DI\Container $container */ $container->get(EntityManager::class));
