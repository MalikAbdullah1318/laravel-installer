@extends('installer::installer.layout')

@section('title', 'Installation - Database Migration')

@section('header', 'Database Migration')

@section(
    'description',
    'Create the database tables required by your application.'
)

@section('content')

    <div class="installer-body">

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step active"></div>

        </div>


        @if(isset($success))

            @if($success)

                <div class="alert alert-success">

                    Database tables were created successfully.

                </div>

            @else

                <div class="alert alert-error">

                    <strong>
                        Database migration failed.
                    </strong>

                    <div style="margin-top: 6px;">
                        {{ $output }}
                    </div>

                </div>

            @endif

        @endif


        <h2 class="section-title">
            Database Migration
        </h2>

        <p class="section-description">
            Click the button below to run the application's
            database migrations.
        </p>


        @if(isset($output))

            <div class="migration-output">{{ $output }}</div>

        @endif

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
                href="{{ url('/') }}"
                class="btn btn-primary"
            >
                Continue
            </a>

        @endif

    </div>

@endsection