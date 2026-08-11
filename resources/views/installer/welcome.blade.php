
@extends('installer::installer.layout')

@section('content')

<div>
    <h1>Welcome</h1>

    <p>
        Welcome to the application installation wizard.
    </p>

    <a href="{{ route('installer.requirements') }}">
        Start Installation
    </a>
</div>

@endsection