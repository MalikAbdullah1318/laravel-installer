@extends('installer::installer.layout')

@section('title', 'Installation - Database Configuration')

@section('content')

 <h1>Database Configuration</h1>

    <p>
        Enter the database information for your application.
    </p>


    @if(session('database_success'))

        <div>
            {{ session('database_success') }}
        </div>

    @endif


    @if(session('database_error'))

        <div>
            {{ session('database_error') }}
        </div>

    @endif


    @if($errors->any())

        <div>

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('installer.database.test') }}"
    >

        @csrf


        <div>

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


        <div>

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


        <div>

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


        <div>

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


        <div>

            <label>
                Database Password
            </label>

            <input
                type="password"
                name="database_password"
                value="{{ old('database_password') }}"
            >

        </div>


        <button type="submit">
            Test Database Connection
        </button>

    </form>


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

            <button type="submit">
                Continue
            </button>

        </form>

    @endif


@endsection