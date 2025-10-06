<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            /* Estilos personalizados para login */
            :root {
                --color-institucional: #233e6c;
                --color-institucional-hover: #1a2d4f;
            }

            body {
                font-family: 'Figtree', sans-serif;
            }

            /* Inputs con focus personalizado */
            input[type="email"]:focus,
            input[type="password"]:focus {
                outline: none;
                border-color: var(--color-institucional) !important;
                box-shadow: 0 0 0 3px rgba(35, 62, 108, 0.1) !important;
            }

            /* Checkbox personalizado */
            input[type="checkbox"]:checked {
                background-color: var(--color-institucional) !important;
                border-color: var(--color-institucional) !important;
            }

            input[type="checkbox"]:focus {
                box-shadow: 0 0 0 3px rgba(35, 62, 108, 0.2) !important;
            }

            /* Botón de login */
            .btn-login {
                background-color: var(--color-institucional);
                transition: all 0.3s ease;
            }

            .btn-login:hover {
                background-color: var(--color-institucional-hover);
                transform: translateY(-1px);
            }

            .btn-login:active {
                transform: translateY(1px);
            }

            /* Animación de entrada */
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

            .fade-in-up {
                animation: fadeInUp 0.5s ease-out;
            }

            /* Efecto de resplandor en el logo */
            @keyframes pulse-subtle {
                0%, 100% {
                    box-shadow: 0 0 0 0 rgba(35, 62, 108, 0.4);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(35, 62, 108, 0);
                }
            }

            .logo-container {
                animation: pulse-subtle 3s infinite;
            }

            /* Estilos del card */
            .login-card {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center px-4" style="background-color: #f8fafc;">
            <div class="w-full max-w-xs">
                <!-- Logo y título -->
                <div class="text-center mb-8 fade-in-up">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4 logo-container" style="background-color: #233e6c;">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2" style="color: #233e6c;">Sistema de Presupuesto</h1>
                    <p class="text-gray-600">The Victoria School</p>
                </div>

                <!-- Card de login -->
                <div class="login-card">
                    <div class="px-12 py-10">
                        {{ $slot }}
                    </div>
                    <div class="px-12 py-4 border-t border-gray-200" style="background-color: #f8fafc;">
                        <p class="text-xs text-center text-gray-500">
                            © {{ date('Y') }} The Victoria School. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
