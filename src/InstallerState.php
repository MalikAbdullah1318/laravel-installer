<?php

namespace MalikAbdullah1318\LaravelInstaller;

use RuntimeException;

class InstallerState
{
    public function get(): array
    {
        $file = config('installer.state_file');

        if (! file_exists($file)) {
            return [];
        }

        $contents = file_get_contents($file);

        if ($contents === false || $contents === '') {
            return [];
        }

        $data = json_decode($contents, true);

        return is_array($data) ? $data : [];
    }


    public function put(array $data): void
    {
        $file = config('installer.state_file');

        $directory = dirname($file);

        if (
            ! is_dir($directory) &&
            ! mkdir($directory, 0755, true) &&
            ! is_dir($directory)
        ) {
            throw new RuntimeException(
                'Unable to create installer state directory.'
            );
        }

        $result = file_put_contents(
            $file,
            json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            ),
            LOCK_EX
        );

        if ($result === false) {
            throw new RuntimeException(
                'Unable to write installer state file.'
            );
        }
    }


    public function forget(): void
    {
        $file = config('installer.state_file');

        if (file_exists($file)) {

            if (! unlink($file)) {
                throw new RuntimeException(
                    'Unable to remove installer state file.'
                );
            }
        }
    }
}