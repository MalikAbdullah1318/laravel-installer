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

    protected function checkPhp(
        string $constraint
    ): RequirementResult {
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
        $constraint = trim($constraint);

        /*
        |--------------------------------------------------------------------------
        | Any Version
        |--------------------------------------------------------------------------
        */

        if ($constraint === '*' || $constraint === '') {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | OR Constraints
        |--------------------------------------------------------------------------
        */

        if (str_contains($constraint, '||')) {
            foreach (explode('||', $constraint) as $part) {
                if (
                    $this->versionSatisfies(
                        $version,
                        trim($part)
                    )
                ) {
                    return true;
                }
            }

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Multiple AND Constraints
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($constraint, ' ') &&
            preg_match('/[<>=~^]/', $constraint)
        ) {
            foreach (
                preg_split('/\s+/', $constraint)
                as $part
            ) {
                if (
                    ! $this->versionSatisfies(
                        $version,
                        $part
                    )
                ) {
                    return false;
                }
            }

            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Caret
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '^')) {
            $required = trim(
                substr($constraint, 1)
            );

            [$major, $minor, $patch] =
                $this->versionParts($required);

            if ($major > 0) {
                $upper = ($major + 1) . '.0.0';
            } elseif ($minor > 0) {
                $upper = '0.' . ($minor + 1) . '.0';
            } else {
                $upper = '0.0.' . ($patch + 1);
            }

            return version_compare(
                $version,
                $required,
                '>='
            ) && version_compare(
                $version,
                $upper,
                '<'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Tilde
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '~')) {
            $required = trim(
                substr($constraint, 1)
            );

            [$major, $minor] =
                $this->versionParts($required);

            $upper = $major . '.' . ($minor + 1) . '.0';

            return version_compare(
                $version,
                $required,
                '>='
            ) && version_compare(
                $version,
                $upper,
                '<'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Greater Than / Equal
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '>=')) {
            return version_compare(
                $version,
                trim(substr($constraint, 2)),
                '>='
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Less Than / Equal
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '<=')) {
            return version_compare(
                $version,
                trim(substr($constraint, 2)),
                '<='
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Greater Than
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '>')) {
            return version_compare(
                $version,
                trim(substr($constraint, 1)),
                '>'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Less Than
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($constraint, '<')) {
            return version_compare(
                $version,
                trim(substr($constraint, 1)),
                '<'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Wildcard
        |--------------------------------------------------------------------------
        */

        if (str_contains($constraint, '*')) {
            $pattern = '/^' .
                str_replace(
                    ['.', '*'],
                    ['\.', '.*'],
                    $constraint
                ) .
                '$/';

            return preg_match(
                $pattern,
                $version
            ) === 1;
        }

        /*
        |--------------------------------------------------------------------------
        | Exact Version
        |--------------------------------------------------------------------------
        */

        return version_compare(
            $version,
            $constraint,
            '='
        );
    }

    protected function versionParts(
        string $version
    ): array {
        $parts = explode('.', $version);

        return [
            (int) ($parts[0] ?? 0),
            (int) ($parts[1] ?? 0),
            (int) ($parts[2] ?? 0),
        ];
    }
}