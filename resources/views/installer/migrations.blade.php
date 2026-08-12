@extends('installer::installer.layout')

@section('title', 'Installation - Database Setup')

@section('content')

    <div class="installer-header">

        <h1 class="installer-title">
            Database Setup
        </h1>

        <p class="installer-description">
            Your database connection has been configured.
            The next step is to create the required database tables.
        </p>

    </div>


    <div class="installer-body">

        {{-- Progress --}}

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step"></div>

        </div>


        @if(isset($success))

            @if($success)

                <div class="all-passed">

                    Database tables were created successfully.

                </div>

            @else

                <div class="has-failed">

                    <strong>
                        Database migration failed.
                    </strong>

                    <p>
                        {{ $output }}
                    </p>

                </div>

            @endif

        @endif


        <div class="requirements-section">

            <h2 class="section-title">
                Database Migration
            </h2>

            <p>
                Click the button below to create the tables
                required by this application.
            </p>


            @if(isset($output))

                <pre>{{ $output }}</pre>

            @endif

        </div>

    </div>


    <div class="installer-footer">

        <a
            href="{{ route('installer.database') }}"
            class="btn"
        >
            Back
        </a>


        @if(!isset($success) || !$success)

            <form
                method="POST"
                action="{{ route('installer.migrations.run') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Run Migrations
                </button>

            </form>

        @else

            <a
                href="#"
                class="btn btn-primary"
            >
                Continue
            </a>

        @endif

    </div>

@endsection