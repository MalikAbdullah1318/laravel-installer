@extends('installer::installer.layout')

@section('title', 'Installation - Database Setup')

@section('content')
    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
        }

        .success {
            padding: 20px;
            background: #d1fae5;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .error {
            padding: 20px;
            background: #fee2e2;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .output {
            background: #111827;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            white-space: pre-wrap;
            overflow-x: auto;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }

        .button:hover {
            background: #1d4ed8;
        }

    </style>

<div class="container">

    @if($success)

        <div class="success">

            <h1>
                Installation Completed
            </h1>

            <p>
                Your application has been installed successfully.
            </p>

            <p>
                The database has been configured, migrations
                have been completed, and the application is ready.
            </p>

        </div>

        @if(!empty($output))

            <h2>
                Installation Output
            </h2>

            <div class="output">{{ $output }}</div>

        @endif

        <a
            href="{{ url('/') }}"
            class="button"
        >
            Visit Application
        </a>

    @else

        <div class="error">

            <h1>
                Installation Failed
            </h1>

            <p>
                Something went wrong during installation.
            </p>

        </div>

        <h2>
            Error Details
        </h2>

        <div class="output">{{ $output }}</div>

        <a
            href="{{ route('installer.migrations') }}"
            class="button"
        >
            Try Again
        </a>

    @endif

</div>

@endsection