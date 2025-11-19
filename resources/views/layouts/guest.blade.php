<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rental Property') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-white antialiased bg-black"> 
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black text-white"> 
        <div class="flex flex-col items-center mb-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current" /> 
            </a>
            <span class="mt-3 text-2xl font-extrabold text-white">Rental Property</span>
            </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black shadow-xl dark:shadow-orange-700/50 overflow-hidden sm:rounded-lg border border-orange-600/50">
            {{ $slot }}
        </div>
    </div>
</body>
</html>