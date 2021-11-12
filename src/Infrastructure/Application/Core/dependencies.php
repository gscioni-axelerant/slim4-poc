<?php

declare(strict_types=1);

use App\Infrastructure\Application\Settings\SettingsInterface;
use App\Infrastructure\Domain\Types\UuidType;
use DI\ContainerBuilder;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        EntityManager::class => static function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $doctrineSettings = $settings->get('doctrine');
            $is_dev = ('production' !== $_SERVER['APP_ENV']);
            $proxy_dir = null;

            if (!$is_dev) {
                $proxy_dir = $doctrineSettings['proxy_dir'];
            }

            Type::addType('uuid', UuidType::class);

            $config = Setup::createXMLMetadataConfiguration([$doctrineSettings['metadata_dir']], $is_dev, $proxy_dir);

            $conn = [
                'url' => $_SERVER['DATABASE_URL'],
            ];

            return EntityManager::create($conn, $config);
        },
    ]);
};
