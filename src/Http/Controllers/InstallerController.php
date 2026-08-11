<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use MalikAbdullah1318\LaravelInstaller\Installer;
use MalikAbdullah1318\LaravelInstaller\Requirements\RequirementsChecker;

class InstallerController extends Controller
{
    public function __construct(
        protected Installer $installer,
        protected RequirementsChecker $requirementsChecker
    ) {
    }

    public function welcome()
    {
        return view(
            'installer::installer.welcome'
        );
    }

    public function requirements()
    {
        $requirements = $this->requirementsChecker->check();

        $requirementsPassed = collect($requirements)
            ->every(
                fn ($requirement) => $requirement->passed
            );

        return view(
            'installer::installer.requirements',
            compact(
                'requirements',
                'requirementsPassed'
            )
        );
    }
}