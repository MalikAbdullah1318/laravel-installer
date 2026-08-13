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
            color: #065f46;
        }

        .error {
            padding: 12px;
            background: #fee2e2;
            margin-bottom: 20px;
            color: #991b1b;
        }

        .continue {
            margin-top: 20px;
            padding: 15px;
            background: #eff6ff;
        }

        .continue button {
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Database Configuration</h1>

    <p>
        Enter your database credentials below.
    </p>


    {{-- Success --}}

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


    {{-- Validation Errors --}}

    @if($errors->any())

        <div class="error">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- Database Test Form --}}

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


    {{-- Continue after successful test --}}

    @if(session('database_success'))

        <div class="continue">

            <strong>
                Database connection verified.
            </strong>

            <p>
                Your database connection is working correctly.
                You can now continue with the installation.
            </p>


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
                    Continue Installation
                </button>

            </form>

        </div>

    @endif

</div>

</body>
</html>