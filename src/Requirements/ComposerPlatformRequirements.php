<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

use RuntimeException;

class ComposerPlatformRequirements
{
    public function check(): array
    {
        $composerPath = base_path('composer.lock');

        if (! file_exists($composerPath)) {
            return [];
        }

        $contents = file_get_contents($composerPath);

        $lock = json_decode(
            $contents,
            true
        );

        if (! is_array($lock)) {
            throw new RuntimeException(
                'composer.lock contains invalid JSON.'
            );
        }

        $results = [];

        $packages = array_merge(
            $lock['packages'] ?? [],
            $lock['packages-dev'] ?? []
        );

        $requirements = [];

        foreach ($packages as $package) {
            foreach (
                $package['require'] ?? []
                as $name => $constraint
            ) {
                if (
                    $name === 'php' ||
                    str_starts_with($name, 'ext-')
                ) {
                    $requirements[$name] = $constraint;
                }
            }
        }

        foreach ($requirements as $name => $constraint) {

            if ($name === 'php') {
                $results[] = $this->checkPhp(
                    $constraint
                );

                continue;
            }

            $extension = substr(
                $name,
                4
            );

            $results[] = $this->checkExtension(
                $extension,
                $constraint
            );
        }

        return $results;
    }

    protected function checkPhp(
        string $constraint
    ): RequirementResult {
        return new RequirementResult(
            name: 'PHP',
            type: 'php',
            required: $constraint,
            current: PHP_VERSION,
            passed: version_compare(
                PHP_VERSION,
                ltrim($constraint, '^>=<~'),
                '>='
            ),
        );
    }

    protected function checkExtension(
        string $extension,
        string $constraint
    ): RequirementResult {
        $installed = extension_loaded(
            $extension
        );

        return new RequirementResult(
            name: $extension,
            type: 'extension',
            required: $constraint,
            current: $installed
                ? phpversion($extension) ?: 'Enabled'
                : 'Not installed',
            passed: $installed,
        );
    }
}