@extends('layout')

<!--Built on top of the sample here https://bootsnipp.com/snippets/featured/todo-example  -->
@section('head')
    {{ Html::style('css/home.css') }}
@endsection

@section('content')
    <!------ Include the above in your HEAD tag ---------->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="todolist not-done">
                    <h1>My Day</h1>
                    <input type="text" class="form-control add-todo" placeholder="Add task">
                    <button id="checkAll" class="btn">Submit</button>
                    
                    <hr>
                    <ul id="sortable" class="list-group todolist-list">
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" /> Take out the trash</label> <br><font color="grey"> Go to dumpster, place trash inside dumpster, do dance, shout 'yatta' from the skies, I dunno, I'm just trying to make a large description and I don't speak Lorem Ipsem. </font><i class='fa fa-plus'></i>
                            </div>
                        </li>
                        <li class="list-group-item" >
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" />Buy bread</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" />Teach penguins to fly</label>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <button id="checkAll" class="btn">
                        Completed
                    </button>
                    <br>
                    <div class="todo-footer">
                        <strong>
                            <span class="count-todos"></span>
                        </strong> Items Left
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="todolist">
                    <h1>Already Done</h1>
                    <ul id="done-items" class="list-unstyled">
                        <li>Some item</li>
                        
                    </ul>
                    
                    <div class="text-center">
                        <button href="" class="btn" data-toggle="modal" data-target="#modalLoginForm">Login</button>
                    </div>
                    
                </div>
                <div class="jumbotron user-account-box">
                    <div style="position: relative;">
                        <span style="float: left;">
                            <img src="/images/defaultProfile.jpg" height="100" width="100">
                        </span>
                        <span> <h3> Cameron </h3></span>
                    </div>
                    <hr>
                    <p> User profiles: </p>
                    <ul class="list-group">
                        <li class="list-group-item">Cameron</li>
                        <li class="list-group-item">Ron</li>
                    </ul>
                    <hr class="my-4">
                    <div class="text-center">
                        <button href="" class="btn" data-toggle="modal" data-target="#modalLoginForm">Add profile</button>
                    </div>
                </div>
        </div>
    </div>
@endsection


@section('footer')
    <div class="footer-bar">
        Cameron
    </div>
    <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Cameron</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">My Day <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Game project #1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                <li class="nav-item dropup">
                    <a class="nav-link dropdown-toggle" href="https://getbootstrap.com" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other tasklists..</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown10">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-number circle" data-type="plus" data-field="quant[1]">
                            <i class='fa fa-plus'></i>
                        </button>
                    </span>
                </li>
            </ul>
        </div>
    </nav>
@endsection
