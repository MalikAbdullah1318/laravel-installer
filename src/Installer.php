<?php

namespace MalikAbdullah1318\LaravelInstaller;

class Installer
{
    public function isInstalled(): bool
    {
        return file_exists(
            config('installer.lock_file')
        );
    }

    public function markAsInstalled(): void
    {
        $lockFile = config('installer.lock_file');

        if (! is_dir(dirname($lockFile))) {
            mkdir(
                dirname($lockFile),
                0755,
                true
            );
        }

        file_put_contents(
            $lockFile,
            now()->toIso8601String()
        );
    }
}