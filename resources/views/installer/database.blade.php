<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Database Configuration</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            cursor: pointer;
        }

        .success {
            padding: 12px;
            background: #d1fae5;
            margin-bottom: 20px;
        }

        .error {
            padding: 12px;
            background: #fee2e2;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 30px;
        }

    </style>

</head>


<body>

<div class="container">

    <h1>Database Configuration</h1>

    <p>
        Enter your database credentials below.
    </p>


    {{-- Database Success --}}

    @if(session('database_success'))

        <div class="success">

            {{ session('database_success') }}

        </div>

    @endif


    {{-- Database Error --}}

    @if(session('database_error'))

        <div class="error">

            {{ session('database_error') }}

        </div>

    @endif


    {{-- Environment Error --}}

    @if(session('environment_error'))

        <div class="error">

            {{ session('environment_error') }}

        </div>

    @endif





    {{-- ========================================================= --}}
    {{-- TEST DATABASE --}}
    {{-- ========================================================= --}}

    <h2>Test Database Connection</h2>


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
                value="{{ old('database_port', 3306) }}"
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


        <button type="submit">
            Test Connection
        </button>

    </form>


    {{-- ========================================================= --}}
    {{-- CONFIGURE DATABASE --}}
    {{-- ========================================================= --}}



        @if(session('database_tested'))

    <hr style="margin: 30px 0;">

    <div class="section">

        <h2>
            Install Application
        </h2>

        <p>
            The database connection has been verified.
            You can now configure your application.
        </p>

        <form
            method="POST"
            action="{{ route('installer.database.configure') }}"
        >

            @csrf

            <div class="form-group">

                <label>
                    Database Host
                </label>

                <input
                    type="text"
                    name="database_host"
                    value="{{ $databaseCredentials['database_host'] ?? '' }}"
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
                    value="{{ $databaseCredentials['database_port'] ?? 3306 }}"
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
                    value="{{ $databaseCredentials['database_name'] ?? '' }}"
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
                    value="{{ $databaseCredentials['database_username'] ?? '' }}"
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
                    value="{{ $databaseCredentials['database_password'] ?? '' }}"
                >

            </div>

            <button type="submit">
                Install Application
            </button>

        </form>

    </div>

@endif



</div>

</body>

</html>