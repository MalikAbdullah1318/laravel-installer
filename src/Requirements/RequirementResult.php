<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

class RequirementResult
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly mixed $required,
        public readonly mixed $current,
        public readonly bool $passed,
        public readonly ?string $message = null,
    ) {
    }
}