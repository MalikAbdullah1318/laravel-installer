<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use MalikAbdullah1318\LaravelInstaller\Installer;
use MalikAbdullah1318\LaravelInstaller\Requirements\RequirementsChecker;

class InstallerController extends Controller
{
    public function __construct(
        protected Installer $installer,
        protected RequirementsChecker $requirementsChecker,
        protected EnvironmentManager $environmentManager
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

    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    */

    public function database()
    {
        return view(
            'installer::installer.database'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Test Database
    |--------------------------------------------------------------------------
    */

    public function testDatabase(Request $request)
    {
        $validated = $request->validate([
            'database_host' => [
                'required',
                'string',
                'max:255',
            ],

            'database_port' => [
                'required',
                'integer',
                'between:1,65535',
            ],

            'database_name' => [
                'required',
                'string',
                'max:255',
            ],

            'database_username' => [
                'required',
                'string',
                'max:255',
            ],

            'database_password' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        try {

            $connection = new \PDO(
                'mysql:host=' .
                $validated['database_host'] .
                ';port=' .
                $validated['database_port'] .
                ';dbname=' .
                $validated['database_name'],

                $validated['database_username'],

                $validated['database_password'] ?? ''
            );

            return back()
                ->withInput()
                ->with(
                    'database_success',
                    'Database connection was successful.'
                );

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'database_error',
                    'Unable to connect to the database. Please check your credentials.'
                );
        }
    }

    public function configureDatabase(Request $request)
    {
        $validated = $request->validate([
            'database_host' => [
                'required',
                'string',
                'max:255',
            ],

            'database_port' => [
                'required',
                'integer',
                'between:1,65535',
            ],

            'database_name' => [
                'required',
                'string',
                'max:255',
            ],

            'database_username' => [
                'required',
                'string',
                'max:255',
            ],

            'database_password' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | Create .env
            |--------------------------------------------------------------------------
            */

            $this->environmentManager->createFromExample();


            /*
            |--------------------------------------------------------------------------
            | Write database configuration
            |--------------------------------------------------------------------------
            */

            $this->environmentManager->setMany([
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => $validated['database_host'],
                'DB_PORT' => $validated['database_port'],
                'DB_DATABASE' => $validated['database_name'],
                'DB_USERNAME' => $validated['database_username'],
                'DB_PASSWORD' => $validated['database_password'] ?? '',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Generate application key
            |--------------------------------------------------------------------------
            */

            Artisan::call('key:generate', [
                '--force' => true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Clear cached configuration
            |--------------------------------------------------------------------------
            */

            Artisan::call('config:clear');


            return redirect()
                ->route('installer.database')
                ->with(
                    'environment_success',
                    '.env has been created and the application configuration has been saved.'
                );

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'environment_error',
                    $e->getMessage()
                );
        }
    }
}