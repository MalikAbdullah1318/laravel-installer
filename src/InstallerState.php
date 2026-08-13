<?php

namespace MalikAbdullah1318\LaravelInstaller;

class InstallerState
{
    public function get(): array
    {
        $file = config('installer.state_file');

        if (! file_exists($file)) {
            return [];
        }

        $contents = file_get_contents($file);

        if (! $contents) {
            return [];
        }

        $data = json_decode($contents, true);

        return is_array($data) ? $data : [];
    }

    public function put(array $data): void
    {
        $file = config('installer.state_file');

        $directory = dirname($file);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            $file,
            json_encode(
                $data,
                JSON_PRETTY_PRINT
            ),
            LOCK_EX
        );
    }

    public function forget(): void
    {
        $file = config('installer.state_file');

        if (file_exists($file)) {
            unlink($file);
        }
    }
}