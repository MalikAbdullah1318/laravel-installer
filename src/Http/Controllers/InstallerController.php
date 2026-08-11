<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use MalikAbdullah1318\LaravelInstaller\Installer;

class InstallerController extends Controller
{
    public function welcome()
    {
        return view('installer::installer.welcome');
    }

    public function requirements()
    {
        return view('installer::installer.requirements');
    }
}