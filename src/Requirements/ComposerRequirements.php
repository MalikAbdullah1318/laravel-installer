<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

use Composer\Semver\Semver;
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

    protected function checkPhp(
        string $constraint
    ): RequirementResult {
        $current = PHP_VERSION;

        $passed = Semver::satisfies(
            $current,
            $constraint
        );

        return new RequirementResult(
            name: 'PHP',
            type: 'php',
            required: $constraint,
            current: $current,
            passed: $passed,
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
}