<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: #f8fafc;
                color: #1f2937;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }

            .container {
                width: 100%;
                max-width: 400px;
            }

            .header {
                text-align: center;
                margin-bottom: 2rem;
                animation: fadeInUp 0.5s ease-out;
            }

            .logo-container {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background-color: #233e6c;
                margin-bottom: 1rem;
                animation: pulse-subtle 3s infinite;
            }

            .logo-container svg {
                width: 48px;
                height: 48px;
                color: white;
            }

            h1 {
                font-size: 2rem;
                font-weight: 700;
                color: #233e6c;
                margin-bottom: 0.5rem;
            }

            .subtitle {
                color: #6b7280;
                font-size: 1rem;
            }

            .login-card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-body {
                padding: 3rem;
            }

            .card-footer {
                padding: 1rem 3rem;
                border-top: 1px solid #e5e7eb;
                background-color: #f8fafc;
                text-align: center;
            }

            .card-footer p {
                font-size: 0.75rem;
                color: #6b7280;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #233e6c;
                margin-bottom: 0.5rem;
            }

            input[type="email"],
            input[type="password"] {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                font-size: 1rem;
                transition: all 0.2s;
            }

            input[type="email"]:focus,
            input[type="password"]:focus {
                outline: none;
                border-color: #233e6c;
                box-shadow: 0 0 0 3px rgba(35, 62, 108, 0.1);
            }

            .checkbox-group {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.5rem;
            }

            .checkbox-wrapper {
                display: flex;
                align-items: center;
                cursor: pointer;
            }

            input[type="checkbox"] {
                width: 18px;
                height: 18px;
                margin-right: 0.5rem;
                cursor: pointer;
                accent-color: #233e6c;
            }

            .checkbox-label {
                font-size: 0.875rem;
                color: #6b7280;
                cursor: pointer;
            }

            .forgot-password {
                font-size: 0.875rem;
                color: #233e6c;
                text-decoration: none;
                font-weight: 500;
            }

            .forgot-password:hover {
                text-decoration: underline;
            }

            .btn-login {
                width: 100%;
                padding: 0.75rem 1rem;
                background-color: #233e6c;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .btn-login:hover {
                background-color: #1a2d4f;
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            .btn-login svg {
                width: 20px;
                height: 20px;
            }

            .error-message {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }

            .status-message {
                padding: 0.75rem;
                background-color: #d1fae5;
                color: #065f46;
                border-radius: 8px;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pulse-subtle {
                0%, 100% {
                    box-shadow: 0 0 0 0 rgba(35, 62, 108, 0.4);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(35, 62, 108, 0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.5s ease-out;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo-container">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1>Sistema de Presupuesto</h1>
                <p class="subtitle">The Victoria School</p>
            </div>

            <div class="login-card">
                <div class="card-body">
                    {{ $slot }}
                </div>
                <div class="card-footer">
                    <p>© {{ date('Y') }} The Victoria School. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </body>
</html>
