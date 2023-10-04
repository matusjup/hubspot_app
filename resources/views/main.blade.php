<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="authorization" content="@auth Bearer {{ auth()->user()->api_token }} @endauth">

        <title> {{ config('app.name') }} @yield('page_title')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div id='app' class="overflow-auto">
            @if ( Route::current()->getName() === 'login-page' )

                @yield('content')

            @else

                @include('admin.layouts.topbar')

                <div id="container">

                    @include('admin.layouts.leftbar')

                </div>

            @endif
        </div>
    </body>
</html>
