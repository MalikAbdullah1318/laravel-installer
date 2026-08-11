<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

class RequirementsChecker
{
    public function __construct(
        protected ComposerRequirements $composerRequirements,
        protected ComposerPlatformRequirements $platformRequirements
    ) {
    }

    public function check(): array
    {
        return array_merge(
            $this->composerRequirements->check(),
            $this->platformRequirements->check()
        );
    }
}