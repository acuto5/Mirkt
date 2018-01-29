<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

        {{-- favicon--}}
        <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>

        {{--CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Title --}}
        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Material icons --}}
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">

        {{--Styles --}}
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <router-view :messages="messages"></router-view>
        </div>

        <script>
            window.URLS = {!! App\Http\Controllers\RoutesController::getRoutes() !!};

            @if(Auth::check())
                window.USER = {!! Auth::user() !!};
            @else
                window.USER = {};
            @endif
        </script>

        @if(Auth::check())
            @if(Auth::user()->isAdmin() || Auth::user()->isModerator())
                <script src="{{mix('js/appAndDashboard.js')}}"></script> {{-- Admin or Moderator --}}
            @else
                <script src="{{ mix('js/app.js') }}"></script> {{-- Auth --}}
            @endif
        @else
            <script src="{{ mix('js/app.js') }}"></script> {{-- Guest --}}
        @endif
    </body>
</html>