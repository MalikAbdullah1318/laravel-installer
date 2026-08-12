<?php

namespace MalikAbdullah1318\LaravelInstaller\Environment;

use RuntimeException;

class EnvironmentManager
{
    public function exists(): bool
    {
        return file_exists(base_path('.env'));
    }

    public function createFromExample(): void
    {
        $envPath = base_path('.env');
        $examplePath = base_path('.env.example');

        if ($this->exists()) {
            return;
        }

        if (! file_exists($examplePath)) {
            throw new RuntimeException(
                '.env.example file was not found.'
            );
        }

        if (! copy($examplePath, $envPath)) {
            throw new RuntimeException(
                'Unable to create the .env file.'
            );
        }
    }

    public function set(string $key, string $value): void
    {
        $this->createFromExample();

        $envPath = base_path('.env');

        $contents = file_get_contents($envPath);

        if ($contents === false) {
            throw new RuntimeException(
                'Unable to read the .env file.'
            );
        }

        $value = $this->formatValue($value);

        $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';

        if (preg_match($pattern, $contents)) {
            $contents = preg_replace(
                $pattern,
                $key . '=' . $value,
                $contents
            );
        } else {
            $contents .= PHP_EOL . $key . '=' . $value;
        }

        if (file_put_contents($envPath, $contents) === false) {
            throw new RuntimeException(
                'Unable to write to the .env file.'
            );
        }
    }

    public function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->set($key, (string) $value);
        }
    }

    protected function formatValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (
            str_contains($value, ' ') ||
            str_contains($value, '#') ||
            str_contains($value, '"') ||
            str_contains($value, "'")
        ) {
            return '"' . str_replace(
                '"',
                '\"',
                $value
            ) . '"';
        }

        return $value;
    }
}