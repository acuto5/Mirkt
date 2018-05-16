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
        @if(config('app.env') === 'local')
            <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @else
            <link href="https://static.mirkt.lt/css/app.css" rel="stylesheet">
        @endif
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script>
            window.CategoriesWithSubCategories = Object.freeze({!! getAllCategoriesWithSubCategories() !!});
            window.CategoriesWithSubCategories.map( category => Object.freeze( category ) );

            window.URLS = Object.freeze({!! getAllRoutes() !!});

            @if(Auth::check())
                window.USER = Object.freeze({!! Auth::user() !!});
            @else
                window.USER = Object.freeze( {} );
            @endif
        </script>

        @if(Auth::check())
            @if(Auth::user()->isAdmin() || Auth::user()->isModerator())
                @if(config('app.env') === 'local')
                    <script src="{{mix('js/appWithDashboard.js')}}"></script> {{-- Admin or Moderator --}}
                @else
                    <script src="https://static.mirkt.lt/js/appWithDashboard.js"></script> {{-- Admin or Moderator --}}
                @endif
            @else
                @if(config('app.env') === 'local')
                    <script src="{{ mix('js/app.js') }}"></script> {{-- Auth --}}
                @else
                    <script src="https://static.mirkt.lt/js/app.js"></script> {{-- Auth --}}
                @endif
            @endif
        @else
            @if(config('app.env') === 'local')
                <script src="{{ mix('js/app.js') }}"></script> {{-- Auth --}}
            @else
                <script src="https://static.mirkt.lt/js/app.js"></script> {{-- Auth --}}
            @endif
        @endif
    </body>
</html>