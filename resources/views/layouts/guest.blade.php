<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - ADA AA Kenya</title>
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @yield('content')
    </body>
</html>
