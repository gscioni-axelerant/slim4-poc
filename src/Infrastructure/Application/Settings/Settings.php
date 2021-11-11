<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Settings;

class Settings implements SettingsInterface
{
    public function __construct(
        private array $settings
    ) {
    }

    public function get(string $key = ''): array|string|bool
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
