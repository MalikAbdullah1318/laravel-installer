@extends('installer::installer.layout')

@section('title', 'Installation')

@section('header', 'Welcome')

@section(
    'description',
    'Let’s get your application installed and ready to use.'
)

@section('content')

    <div class="installer-body">

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
            <div class="step"></div>

        </div>


        <h2 class="section-title">
            Welcome to the Installation Wizard
        </h2>

        <p class="section-description">
            This wizard will guide you through the installation
            process. Before we configure your application,
            we'll check your server requirements.
        </p>

    </div>


    <div class="installer-footer">

        <div></div>

        <a
            href="{{ route('installer.requirements') }}"
            class="btn btn-primary"
        >
            Start Installation
        </a>

    </div>

@endsection