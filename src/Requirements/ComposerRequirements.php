<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

use RuntimeException;

class ComposerRequirements implements Requirement
{
    public function check(): array
    {
        $composerPath = base_path('composer.json');

        if (! file_exists($composerPath)) {
            throw new RuntimeException(
                'composer.json was not found.'
            );
        }

        $contents = file_get_contents($composerPath);

        $composer = json_decode(
            $contents,
            true
        );

        if (! is_array($composer)) {
            throw new RuntimeException(
                'composer.json contains invalid JSON.'
            );
        }

        $results = [];

        $requirements = $composer['require'] ?? [];

        foreach ($requirements as $package => $constraint) {

            if ($package === 'php') {
                $results[] = $this->checkPhp($constraint);

                continue;
            }

            if (str_starts_with($package, 'ext-')) {
                $extension = substr($package, 4);

                $results[] = $this->checkExtension(
                    $extension,
                    $constraint
                );
            }
        }

        return $results;
    }

    protected function checkPhp(string $constraint): RequirementResult
    {
        $current = PHP_VERSION;

        return new RequirementResult(
            name: 'PHP',
            type: 'php',
            required: $constraint,
            current: $current,
            passed: $this->versionSatisfies(
                $current,
                $constraint
            ),
        );
    }

    protected function checkExtension(
        string $extension,
        string $constraint
    ): RequirementResult {
        $installed = extension_loaded($extension);

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

    protected function versionSatisfies(
        string $version,
        string $constraint
    ): bool {
        if (str_starts_with($constraint, '>=')) {
            return version_compare(
                $version,
                trim(substr($constraint, 2)),
                '>='
            );
        }

        if (str_starts_with($constraint, '>')) {
            return version_compare(
                $version,
                trim(substr($constraint, 1)),
                '>'
            );
        }

        if (str_starts_with($constraint, '<=')) {
            return version_compare(
                $version,
                trim(substr($constraint, 2)),
                '<='
            );
        }

        if (str_starts_with($constraint, '<')) {
            return version_compare(
                $version,
                trim(substr($constraint, 1)),
                '<'
            );
        }

        return version_compare(
            $version,
            trim($constraint),
            '='
        );
    }
}