<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CRM-ERP All-in-One') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS via CDN (como fallback) -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Scripts e estilos via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Estilos adicionais para gradiente e fontes */
            body {
                font-family: 'Inter', sans-serif;
            }
            .bg-gradient-to-r {
                background-image: linear-gradient(to right, #3b82f6, #8b5cf6);
            }
        </style>
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        @yield('content')
        
        @livewireScripts
    </body>
</html>
