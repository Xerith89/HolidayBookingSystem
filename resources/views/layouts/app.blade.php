<!DOCTYPE html>

<html lang="{{config('app.locale')}}"> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name','SLIS Holiday Booking System')}}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}"  type="text/css" >
    </head>
    <body>
        @yield('content')
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    </body>
</html>