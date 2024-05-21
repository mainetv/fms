<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FMS') }}</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> --}}

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('dist/css/guest.css') }}">
        <style>
            ::placeholder { 
            color: grey!important;
            opacity: 1; 
            }
    
           a{
                color:white!important;
            }
      </style> 
    </head>
    <body style="background-image: url('images/login-bg.jpg'); background-repeat: no-repeat; background-size: cover;">
        {{ $slot }}        
    </body>
</html>