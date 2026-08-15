<?php

namespace MalikAbdullah1318\LaravelInstaller;

use RuntimeException;

class Installer
{
    /*
    |--------------------------------------------------------------------------
    | Check Installation Status
    |--------------------------------------------------------------------------
    */

    public function isInstalled(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Application must have BOTH:
        |
        | 1. .env file
        | 2. Installer lock file
        |
        |--------------------------------------------------------------------------
        */

        return file_exists(base_path('.env'))
            && file_exists($this->lockFile());
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Application As Installed
    |--------------------------------------------------------------------------
    */

    public function markAsInstalled(?string $version = null): void
    {
        $lockFile = $this->lockFile();

        $directory = dirname($lockFile);

        if (
            ! is_dir($directory) &&
            ! mkdir($directory, 0755, true) &&
            ! is_dir($directory)
        ) {
            throw new RuntimeException(
                'Unable to create installer lock directory.'
            );
        }

        $data = [
            'installed_at' => now()->toIso8601String(),
            'version' => $version,
        ];

        if (
            file_put_contents(
                $lockFile,
                json_encode(
                    $data,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                ),
                LOCK_EX
            ) === false
        ) {
            throw new RuntimeException(
                'Unable to create installer lock file.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Get Installed Version
    |--------------------------------------------------------------------------
    */

    public function version(): ?string
    {
        $lockFile = $this->lockFile();

        if (! file_exists($lockFile)) {
            return null;
        }

        $data = json_decode(
            file_get_contents($lockFile),
            true
        );

        return $data['version'] ?? null;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Lock File
    |--------------------------------------------------------------------------
    */

    protected function lockFile(): string
    {
        return config('installer.lock_file');
    }
}