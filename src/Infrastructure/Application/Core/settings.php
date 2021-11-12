<?php

declare(strict_types=1);

use App\Infrastructure\Application\Settings\Settings;
use App\Infrastructure\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__.'/../../../../var/logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    'proxy_dir' => dirname(__DIR__).'/../../../var/doctrine/proxy',
                    'cache_dir' => dirname(__DIR__).'/../../../var/doctrine',
                    'metadata_dir' => dirname(__DIR__).'/../Domain/Mapping',
                ],
            ]);
        },
    ]);
};
