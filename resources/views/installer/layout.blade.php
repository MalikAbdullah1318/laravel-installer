<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Installation')
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            background: #f4f6f8;
            color: #1f2937;
        }

        a {
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .installer-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px 20px;
        }


        /* =========================================================
           MAIN CARD
        ========================================================= */

        .installer-card {
            width: 100%;
            max-width: 820px;

            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.06);

            overflow: hidden;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .installer-header {
            padding: 36px 40px 28px;

            border-bottom: 1px solid #eef0f2;

            text-align: center;
        }

        .installer-logo {
            width: 52px;
            height: 52px;

            margin: 0 auto 18px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #111827;
            color: #ffffff;

            font-size: 22px;
            font-weight: 700;
        }

        .installer-title {
            margin: 0;

            font-size: 28px;
            line-height: 1.25;

            font-weight: 700;

            color: #111827;
        }

        .installer-description {
            max-width: 600px;

            margin: 10px auto 0;

            font-size: 15px;
            line-height: 1.7;

            color: #6b7280;
        }


        /* =========================================================
           BODY
        ========================================================= */

        .installer-body {
            padding: 36px 40px;
        }


        /* =========================================================
           STEP INDICATOR
        ========================================================= */

        .step-indicator {
            display: flex;
            align-items: center;

            width: 100%;

            margin-bottom: 34px;
        }

        .step {
            position: relative;

            flex: 1;

            height: 4px;

            background: #e5e7eb;

            border-radius: 999px;
        }

        .step:not(:last-child) {
            margin-right: 8px;
        }

        .step.active {
            background: #111827;
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .section-title {
            margin: 0 0 12px;

            font-size: 20px;

            font-weight: 650;

            color: #111827;
        }

        .section-description {
            margin: 0;

            font-size: 14px;
            line-height: 1.7;

            color: #6b7280;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .installer-footer {
            padding: 20px 40px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            border-top: 1px solid #eef0f2;

            background: #fafafa;
        }


        /* =========================================================
           BUTTONS
        ========================================================= */

        .btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 42px;

            padding: 0 18px;

            border-radius: 8px;

            border: 1px solid #d1d5db;

            background: #ffffff;

            color: #374151;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition:
                background 0.15s ease,
                border-color 0.15s ease,
                transform 0.15s ease;
        }

        .btn:hover {
            background: #f9fafb;
        }

        .btn-primary {
            background: #111827;

            border-color: #111827;

            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1f2937;

            border-color: #1f2937;
        }

        .btn-disabled {
            background: #e5e7eb;

            border-color: #e5e7eb;

            color: #9ca3af;

            cursor: not-allowed;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            padding: 14px 16px;

            margin-bottom: 24px;

            border-radius: 8px;

            font-size: 14px;

            line-height: 1.6;
        }

        .alert-success {
            background: #ecfdf5;

            border: 1px solid #a7f3d0;

            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;

            border: 1px solid #fecaca;

            color: #991b1b;
        }


        /* =========================================================
           REQUIREMENTS
        ========================================================= */

        .requirements-section {
            margin-top: 28px;
        }

        .requirement {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 18px 0;

            border-bottom: 1px solid #eef0f2;
        }

        .requirement:last-child {
            border-bottom: 0;
        }

        .requirement-name {
            font-size: 15px;

            font-weight: 600;

            color: #111827;
        }

        .requirement-type {
            margin-top: 4px;

            font-size: 12px;

            color: #9ca3af;
        }

        .requirement-values {
            display: flex;

            align-items: center;

            gap: 28px;

            text-align: right;
        }

        .requirement-value {
            min-width: 80px;

            font-size: 13px;

            line-height: 1.6;

            color: #6b7280;
        }

        .requirement-value strong {
            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.04em;

            color: #9ca3af;
        }

        .status {
            min-width: 85px;

            padding: 6px 10px;

            border-radius: 6px;

            text-align: center;

            font-size: 12px;

            font-weight: 600;
        }

        .status-passed {
            background: #ecfdf5;

            color: #047857;
        }

        .status-failed {
            background: #fef2f2;

            color: #b91c1c;
        }


        /* =========================================================
           FORMS
        ========================================================= */

        .form-section {
            margin-top: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: 600;

            color: #374151;
        }

        .form-input {
            width: 100%;

            height: 44px;

            padding: 0 13px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            background: #ffffff;

            color: #111827;

            font-size: 14px;

            outline: none;

            transition:
                border-color 0.15s ease,
                box-shadow 0.15s ease;
        }

        .form-input:focus {
            border-color: #111827;

            box-shadow:
                0 0 0 3px rgba(17, 24, 39, 0.08);
        }

        .form-help {
            margin-top: 6px;

            font-size: 12px;

            color: #9ca3af;
        }


        /* =========================================================
           DATABASE GRID
        ========================================================= */

        .database-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 0 20px;
        }


        /* =========================================================
           MIGRATION OUTPUT
        ========================================================= */

        .migration-output {
            margin-top: 20px;

            padding: 16px;

            max-height: 300px;

            overflow: auto;

            background: #111827;

            border-radius: 8px;

            color: #d1d5db;

            font-family:
                Consolas,
                Monaco,
                monospace;

            font-size: 12px;

            line-height: 1.6;

            white-space: pre-wrap;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 700px) {

            .installer-page {
                padding: 20px 12px;
            }

            .installer-header {
                padding: 28px 22px 22px;
            }

            .installer-body {
                padding: 28px 22px;
            }

            .installer-footer {
                padding: 18px 22px;
            }

            .installer-title {
                font-size: 24px;
            }

            .database-grid {
                grid-template-columns: 1fr;
            }

            .requirement {
                align-items: flex-start;

                flex-direction: column;
            }

            .requirement-values {
                width: 100%;

                justify-content: space-between;

                text-align: left;

                gap: 10px;
            }

            .requirement-value {
                min-width: auto;
            }

        }

    </style>

</head>


<body>

    <div class="installer-page">

        <div class="installer-card">

            <div class="installer-header">

                <div class="installer-logo">
                    ✓
                </div>

                <h1 class="installer-title">
                    @yield('header', 'Installation')
                </h1>

                <p class="installer-description">
                    @yield(
                        'description',
                        'Follow the steps below to install and configure your application.'
                    )
                </p>

            </div>


            @yield('content')

        </div>

    </div>

</body>

</html>