@extends('installer::installer.layout')

@section('title', 'Installation - Database Configuration')

@section('content')

    <div class="installer-header">

        <h1 class="installer-title">
            Database Configuration
        </h1>

        <p class="installer-description">
            Enter the database information for your application.
        </p>

    </div>


    <div class="installer-body">

        {{-- Progress --}}

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>

        </div>


        {{-- Database test success --}}

        @if(session('database_success'))

            <div class="all-passed">
                {{ session('database_success') }}
            </div>

        @endif


        {{-- Database test error --}}

        @if(session('database_error'))

            <div class="has-failed">
                {{ session('database_error') }}
            </div>

        @endif


        {{-- Environment success --}}

        @if(session('environment_success'))

            <div class="all-passed">
                {{ session('environment_success') }}
            </div>

        @endif


        {{-- Environment error --}}

        @if(session('environment_error'))

            <div class="has-failed">
                {{ session('environment_error') }}
            </div>

        @endif


        {{-- Validation errors --}}

        @if($errors->any())

            <div class="has-failed">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- Database form --}}

        <div class="requirements-section">

            <h2 class="section-title">
                Database
            </h2>


            <form
                method="POST"
                action="{{ route('installer.database.test') }}"
            >

                @csrf


                <div class="form-group">

                    <label>
                        Database Host
                    </label>

                    <input
                        type="text"
                        name="database_host"
                        value="{{ old('database_host', '127.0.0.1') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Database Port
                    </label>

                    <input
                        type="number"
                        name="database_port"
                        value="{{ old('database_port', '3306') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Database Name
                    </label>

                    <input
                        type="text"
                        name="database_name"
                        value="{{ old('database_name') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Database Username
                    </label>

                    <input
                        type="text"
                        name="database_username"
                        value="{{ old('database_username') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Database Password
                    </label>

                    <input
                        type="password"
                        name="database_password"
                        value="{{ old('database_password') }}"
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Test Database Connection
                </button>

            </form>


            {{-- Continue after successful connection --}}

            @if(session('database_success'))

                <hr>


                <form
                    method="POST"
                    action="{{ route('installer.database.configure') }}"
                >

                    @csrf


                    <input
                        type="hidden"
                        name="database_host"
                        value="{{ old('database_host') }}"
                    >

                    <input
                        type="hidden"
                        name="database_port"
                        value="{{ old('database_port') }}"
                    >

                    <input
                        type="hidden"
                        name="database_name"
                        value="{{ old('database_name') }}"
                    >

                    <input
                        type="hidden"
                        name="database_username"
                        value="{{ old('database_username') }}"
                    >

                    <input
                        type="hidden"
                        name="database_password"
                        value="{{ old('database_password') }}"
                    >


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Continue
                    </button>

                </form>

            @endif

        </div>

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