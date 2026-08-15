@extends('installer::installer.layout')

@section('title', 'Installation - Database Configuration')

@section('header', 'Database Configuration')

@section(
    'description',
    'Enter your database credentials to connect your application to MySQL.'
)

@section('content')

    <div class="installer-body">

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>

        </div>


        {{-- Success --}}

        @if($databaseSuccess)

            <div class="alert alert-success">
                {{ $databaseSuccess }}
            </div>

        @endif


        {{-- Error --}}

        @if($databaseError)

            <div class="alert alert-error">
                {{ $databaseError }}
            </div>

        @endif


        <h2 class="section-title">
            Test Database Connection
        </h2>

        <p class="section-description">
            Enter your MySQL credentials below. The installer will
            test the connection and create the database if necessary.
        </p>


        <div class="form-section">

            <form
                method="POST"
                action="{{ route('installer.database.test') }}"
            >

                @csrf


                <div class="database-grid">

                    <div class="form-group">

                        <label class="form-label">
                            Database Host
                        </label>

                        <input
                            type="text"
                            name="database_host"
                            class="form-input"
                            value="{{ $databaseCredentials['database_host'] ?? '127.0.0.1' }}"
                            placeholder="127.0.0.1"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Database Port
                        </label>

                        <input
                            type="number"
                            name="database_port"
                            class="form-input"
                            value="{{ $databaseCredentials['database_port'] ?? 3306 }}"
                            placeholder="3306"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Database Name
                    </label>

                    <input
                        type="text"
                        name="database_name"
                        class="form-input"
                        value="{{ $databaseCredentials['database_name'] ?? '' }}"
                        placeholder="your_database"
                        required
                    >

                </div>


                <div class="database-grid">

                    <div class="form-group">

                        <label class="form-label">
                            Database Username
                        </label>

                        <input
                            type="text"
                            name="database_username"
                            class="form-input"
                            value="{{ $databaseCredentials['database_username'] ?? '' }}"
                            placeholder="root"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Database Password
                        </label>

                        <input
                            type="password"
                            name="database_password"
                            class="form-input"
                            value="{{ $databaseCredentials['database_password'] ?? '' }}"
                            placeholder="••••••••"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Test Connection
                </button>

            </form>

        </div>


        {{-- =====================================================
             CONFIGURE APPLICATION
        ====================================================== --}}

        @if($databaseTested)

            <div class="form-section">

                <div class="alert alert-success">

                    Database connection verified successfully.
                    You can now configure the application.

                </div>


                <h2 class="section-title">
                    Configure Application
                </h2>


                <p class="section-description">
                    These credentials will be saved to the application's
                    environment configuration.
                </p>


                <form
                    method="POST"
                    action="{{ route('installer.database.configure') }}"
                    style="margin-top: 24px;"
                >

                    @csrf


                    <div class="database-grid">

                        <div class="form-group">

                            <label class="form-label">
                                Database Host
                            </label>

                            <input
                                type="text"
                                name="database_host"
                                class="form-input"
                                value="{{ $databaseCredentials['database_host'] ?? '' }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Database Port
                            </label>

                            <input
                                type="number"
                                name="database_port"
                                class="form-input"
                                value="{{ $databaseCredentials['database_port'] ?? 3306 }}"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Database Name
                        </label>

                        <input
                            type="text"
                            name="database_name"
                            class="form-input"
                            value="{{ $databaseCredentials['database_name'] ?? '' }}"
                            required
                        >

                    </div>


                    <div class="database-grid">

                        <div class="form-group">

                            <label class="form-label">
                                Database Username
                            </label>

                            <input
                                type="text"
                                name="database_username"
                                class="form-input"
                                value="{{ $databaseCredentials['database_username'] ?? '' }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Database Password
                            </label>

                            <input
                                type="password"
                                name="database_password"
                                class="form-input"
                                value="{{ $databaseCredentials['database_password'] ?? '' }}"
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Configure Application
                    </button>

                </form>

            </div>

        @endif

    </div>


    <div class="installer-footer">

        <a
            href="{{ route('installer.requirements') }}"
            class="btn"
        >
            Back
        </a>

    </div>

@endsection