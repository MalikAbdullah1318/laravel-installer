<?php

namespace MalikAbdullah1318\LaravelInstaller\Requirements;

class RequirementsChecker
{
    /**
     * @var Requirement[]
     */
    protected array $requirements = [];

    public function add(Requirement $requirement): self
    {
        $this->requirements[] = $requirement;

        return $this;
    }

    /**
     * @return RequirementResult[]
     */
    public function check(): array
    {
        $results = [];

        foreach ($this->requirements as $requirement) {
            $results = array_merge(
                $results,
                $requirement->check()
            );
        }

        return $results;
    }

    public function passes(): bool
    {
        foreach ($this->check() as $result) {
            if (! $result->passed) {
                return false;
            }
        }

        return true;
    }
}