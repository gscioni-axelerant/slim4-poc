<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Settings;

interface SettingsInterface
{
    public function get(string $key = ''): array|string|bool;
}
