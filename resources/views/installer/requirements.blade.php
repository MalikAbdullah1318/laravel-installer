@extends('installer::installer.layout')

@section('title', 'Installation - Requirements')

@section('content')

    <div class="installer-header">

        <h1 class="installer-title">
            Server Requirements
        </h1>

        <p class="installer-description">
            Let's make sure your server meets all the requirements
            before continuing with the installation.
        </p>

    </div>


    <div class="installer-body">

        {{-- Progress --}}

        <div class="step-indicator">

            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
            <div class="step"></div>

        </div>


        {{-- Overall status --}}

        @if($requirementsPassed)

            <div class="all-passed">
                All server requirements have been successfully met.
                You can continue with the installation.
            </div>

        @else

            <div class="has-failed">
                Some server requirements are not satisfied.
                Please fix the failed requirements before continuing.
            </div>

        @endif


        {{-- Requirements --}}

        <div class="requirements-section">

            <h2 class="section-title">
                Requirements
            </h2>

            @foreach($requirements as $requirement)

                <div class="requirement">

                    <div>

                        <div class="requirement-name">
                            {{ $requirement->name }}
                        </div>

                        <div class="requirement-type">
                            {{ ucfirst($requirement->type) }}
                        </div>

                    </div>


                    <div class="requirement-values">

                        <div class="requirement-value">

                            <strong>
                                Required
                            </strong>

                            <br>

                            {{ $requirement->required }}

                        </div>


                        <div class="requirement-value">

                            <strong>
                                Current
                            </strong>

                            <br>

                            {{ $requirement->current }}

                        </div>


                        <div
                            class="status {{
                                $requirement->passed
                                    ? 'status-passed'
                                    : 'status-failed'
                            }}"
                        >

                            @if($requirement->passed)

                                ✓ Passed

                            @else

                                ✕ Failed

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    <div class="installer-footer">

        @if($requirementsPassed)

            <a
                href="#"
                class="btn btn-primary"
            >
                Continue
            </a>

        @else

            <span class="btn btn-disabled">
                Fix Requirements
            </span>

        @endif

    </div>

@endsection