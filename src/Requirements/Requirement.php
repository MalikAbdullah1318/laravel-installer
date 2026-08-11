<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

interface Requirement
{
    public function check(): array;
}