<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

interface Requirement
{
    /**
     * @return RequirementResult[]
     */
    public function check(): array;
}