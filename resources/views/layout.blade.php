<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

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
    <body>
        <header>
            {{Session::get('username')}}
            @yield('header')
        </header>
        <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5">
                                
                                <input type="username" id="username-input" class="form-control validate" placeholder="Username">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-default" id="testButton">
                                Add / Load Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @yield('content')
        <script> 
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

         function addProfile() {
             let name = $('#username-input').val();
             $.post("/createProfile", { _token : CSRF_TOKEN,
                                        "name" : name},
                    function(result){
                        alert(result);
                        alert("create profile success! " + name);
                        alert("{{ Session::get('username') }}");
                    });
             $.post("/login", { _token : CSRF_TOKEN,
                                "name" : name},
                    function(result){
                        alert(result);
                        alert("Login! " + name);
                        alert("{{ Session::get('username') }}");
                    });
             alert("addProfile function ended");
             
         }
         $(document).ready(function(){
             $("#testButton").click(addProfile);
         });  
        </script>
        
        <footer>
            @yield('footer')
        </footer>
    </body>
</html>
