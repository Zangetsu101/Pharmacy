<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script>window.laravel={csrfToken:'{{csrf_token()}}'}</script>

        <title>Tameem Pharmacy</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Icons -->
        <script src="https://kit.fontawesome.com/c733dc5549.js"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    </head>
    <body>
        <div id="app">
            <my-app></my-app>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
