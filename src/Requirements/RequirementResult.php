<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

class RequirementResult
{
    public function __construct(
        public string $name,
        public string $type,
        public string $required,
        public string $current,
        public bool $passed,
        public ?string $message = null,
    ) {
    }
}