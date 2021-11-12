<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Settings;

class Settings implements SettingsInterface
{
    /**
     * @param array $settings
     */
    public function __construct(
        private array $settings
    ) {
    }

    /**
     * @param string $key
     *
     * @return array<string, mixed>|bool|string
     */
    public function get(string $key = ''): array|string|bool
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
