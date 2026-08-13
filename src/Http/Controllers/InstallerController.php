<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use MalikAbdullah1318\LaravelInstaller\Installer;
use MalikAbdullah1318\LaravelInstaller\Requirements\RequirementsChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use MalikAbdullah1318\LaravelInstaller\Environment\EnvironmentManager;
use Illuminate\Support\Facades\Log;

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
        'installer::installer.database',
            [
                'databaseCredentials' => session('database_credentials', []),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Test Database
    |--------------------------------------------------------------------------
    */

    public function testDatabase(Request $request)
{
    Log::info('Database test method started');

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

    Log::info('Database validation passed', [
        'host' => $validated['database_host'],
        'port' => $validated['database_port'],
        'database' => $validated['database_name'],
        'username' => $validated['database_username'],
    ]);

    try {

        Log::info('Attempting MySQL connection');

        $pdo = new \PDO(
            'mysql:host=' .
            $validated['database_host'] .
            ';port=' .
            $validated['database_port'],

            $validated['database_username'],

            $validated['database_password'] ?? '',

            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]
        );

        Log::info('MySQL connection successful');

        $statement = $pdo->prepare(
            'SELECT SCHEMA_NAME
             FROM INFORMATION_SCHEMA.SCHEMATA
             WHERE SCHEMA_NAME = ?'
        );

        $statement->execute([
            $validated['database_name'],
        ]);

        $databaseExists = $statement->fetchColumn();

        Log::info('Database existence checked', [
            'database' => $validated['database_name'],
            'exists' => (bool) $databaseExists,
        ]);

        if (! $databaseExists) {

            Log::info('Database does not exist. Creating database.');

            $databaseName = str_replace(
                '`',
                '``',
                $validated['database_name']
            );

            $pdo->exec(
                "CREATE DATABASE `{$databaseName}`"
            );

            Log::info('Database created successfully');
        }

        Log::info('Database test completed successfully');

        return redirect()
            ->route('installer.database')
            ->with(
                'database_success',
                'Database connection was successful and the database is ready.'
            )
            ->with(
                'database_tested',
                true
            )
            ->with(
                'database_credentials',
                $validated
            );

    } catch (\Throwable $e) {

        Log::error('Database connection failed', [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()
            ->route('installer.database')
            ->with(
                'database_error',
                'Unable to connect to MySQL or create the database. Please check your database credentials and permissions.'
            )
            ->with(
                'database_tested',
                false
            )
            ->with(
                'database_credentials',
                $validated
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
            | Configure database
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
            | Generate APP_KEY
            |--------------------------------------------------------------------------
            */

            Artisan::call('key:generate', [
                '--force' => true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Clear configuration cache
            |--------------------------------------------------------------------------
            */

            Artisan::call('config:clear');


            return redirect()->route('installer.migrations');

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'environment_error',
                    $e->getMessage()
                );
        }
    }

    public function migrations()
    {
        return view(
            'installer::installer.migrations'
        );
    }

    public function runMigrations()
    {
        try {

            Artisan::call('migrate', [
                '--force' => true,
            ]);

            $output = Artisan::output();

            return view(
                'installer::installer.migrations',
                [
                    'success' => true,
                    'output' => $output,
                ]
            );

        } catch (\Throwable $e) {

            return view(
                'installer::installer.migrations',
                [
                    'success' => false,
                    'output' => $e->getMessage(),
                ]
            );
        }
    }
}