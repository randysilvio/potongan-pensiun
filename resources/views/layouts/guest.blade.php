<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GPI Papua</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .background-image {
                background-image: url('{{ asset('images/bcg.jpg') }}');
                background-size: cover;
                background-position: center;
                /* Menambahkan filter blur pada background image */
                filter: blur(5px);
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }
            .content-container {
                /* Menjadikan container konten transparan */
                background-color: rgba(255, 255, 255, 0.8); /* Transparansi 80% */
            }
        </style>

        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 background-image">
            </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="text-2xl font-bold text-gray-800 text-shadow-md">
                    SINODE GEREJA PROTESTAN INDONESIA DI PAPUA
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 content-container shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>