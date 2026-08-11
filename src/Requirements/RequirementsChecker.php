<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

class RequirementsChecker
{
    public function __construct(
        protected ComposerRequirements $composerRequirements
    ) {
    }

    public function check(): array
    {
        return $this->composerRequirements->check();
    }
}