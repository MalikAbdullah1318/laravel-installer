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
                $requirements[$name][] = $constraint;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PHP
    |--------------------------------------------------------------------------
    */

    if (isset($requirements['php'])) {

        $phpRequirements = $requirements['php'];

        $required = $this->strongestPhpRequirement(
            $phpRequirements
        );

        $results[] = $this->checkPhp(
            $required
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Extensions
    |--------------------------------------------------------------------------
    */

    foreach ($requirements as $name => $constraints) {

        if ($name === 'php') {
            continue;
        }

        $extension = substr(
            $name,
            4
        );

        $results[] = $this->checkExtension(
            $extension,
            '*'
        );
    }

    return $results;
}
protected function strongestPhpRequirement(
    array $requirements
): string {
    /*
    |--------------------------------------------------------------------------
    | For now, use the application's direct PHP requirement
    |--------------------------------------------------------------------------
    */

    $composerPath = base_path('composer.json');

    if (file_exists($composerPath)) {

        $composer = json_decode(
            file_get_contents($composerPath),
            true
        );

        if (
            isset($composer['require']['php'])
        ) {
            return $composer['require']['php'];
        }
    }

    return $requirements[0] ?? '*';
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