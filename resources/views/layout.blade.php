<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Todo list</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!-- Scripts -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- Styles ----------------------------------->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- Bootswatch litera-->
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/simplex/bootstrap.min.css" rel="stylesheet" integrity="sha384-C/fi3Y7sgGQc3Lxu71QIVbBJ9iNQ/11o+YZNg2GRUrRrJayHEMpEc2I/jFSkMXAW" crossorigin="anonymous">
        <!-- -  <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-qVp3sGZJcZdk20BIG6O0Sb0sYRyedif3+Z8bZtQueBW/g7Dp67a0XdiMmmWCCm82" crossorigin="anonymous"> -->
        
        @yield('head')
        <!-- ------------------------------------------- -->
    </head>
    <header>
        @yield('header')
    </header>
    <body>
        @yield('content')
    </body>
    <footer>
        @yield('footer')
    </footer>
</html>
