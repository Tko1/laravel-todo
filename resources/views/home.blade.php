@extends('layout')

<!--Built on top of the sample here https://bootsnipp.com/snippets/featured/todo-example  -->
@section('head')
    {{ Html::style('css/home.css') }}
    
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="todolist not-done">
                    <h1>{{ Session::get("taskListName") ?: "No task list loaded" }}</h1>
                    <input type="text" id="add-task-input" class="form-control add-todo" placeholder="Add task">
                    <button id="add-task-button" class="btn">Submit</button>
                    
                    <hr>
                    <ul id="sortable" class="list-group todolist-list">
                        @foreach($tasks as $task)
                            <li class="list-group-item task-list-item">
                                <div class="checkbox">
                                    <label class="task-label" task-id="{{ $task->id }}">
                                        <input type="checkbox" class="task-checkbox" task-id="{{ $task->id }}" value="" /> {{ $task->name }}</label> <br><font color="grey"> </font>
                                </div>
                            </li>
                        @endforeach
                        <!-- Example todo -->
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" /> Take out the trash</label> <br><font color="grey"> Go to dumpster, place trash inside dumpster, do dance, shout 'yatta' from the skies, I dunno, I'm just trying to make a large description and I don't speak Lorem Ipsem. </font><i class='fa fa-plus'></i>
                            </div>
                        </li>
                        
                    </ul>
                    <hr>
                    <button id="complete-checked" class="btn">
                        Complete Checked
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
                        @foreach($completedTasks as $completedTask)
                            <li>{{ $completedTask->name }}</li>
                        @endforeach
                    </ul>
                    
                    <div class="text-center">
                        <button href="" class="btn" data-toggle="modal" data-target="#modalLoginForm">Lokgin</button>
                    </div>
                    
                </div>
                <div class="jumbotron user-profile-box">
                    <div style="position: relative;">
                        <span style="float: left;">
                            <img src="/images/defaultProfile.jpg" height="100" width="100">
                        </span>
                        <span> <h3> {{ Session::get('username') ?: "No profile loaded" }} </h3></span>
                    </div>
                    <hr>
                    <p> User profiles: </p>
                    
                    <ul class="list-group user-profile-list">
                        @foreach($profiles as $profile)
                            <li class="list-group-item">
                                {{$profile}}
                            </li>
                        @endforeach
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
    <script>
     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

     function addTask() {
         console.log("start: addTask");
         let taskName = $('#add-task-input').val();
         let userId   = {{ Session::get('userId') }};
         let taskListId = {{ Session::get('taskListId')  }};
         $.post("/createTask", { _token : CSRF_TOKEN,
                                 "name" : taskName,
                                 "authorId" : userId,
                                 "taskListId" : taskListId},
                function(result){
                    console.log(result);
                    console.log("create task success! " + name);
                }).fail(function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    console.log(" | " + textStatus + " | " + errorThrown);
                });
         alert("addTask function ended");
         
     }
     var taskLabels = document.getElementsByClassName("task-label");
     var taskCheckboxes = document.getElementsByClassName("task-checkbox");
     function completeChecked()
     {
         //task-list-item
         console.log("start: completeChecked");
         let taskLabels = document.getElementsByClassName("task-label");
         let taskCheckboxes = document.getElementsByClassName("task-checkbox");
         let taskCount = {{ $tasks->count() ?: 0 }};
         for (let i = 0; i < taskCount; i++) {
             let label = taskLabels[i];
             let taskId = label.getAttribute("task-id");
             // Must have same task-id and be of the class task-checkbox
             let checkbox = document.querySelectorAll('[task-id="'+taskId+'"].task-checkbox')[0];

             if(checkbox.checked){
                 console.log("Checkbox is checked");
                 console.log(checkbox);
                 $.post("/completeTask", { _token : CSRF_TOKEN,
                                           "taskId" : taskId},
                        function(result){
                            console.log("Complete task worked");
                        }).fail(function(xhr, textStatus, errorThrown) {
                            console.log(xhr);
                            console.log(" | " + textStatus + " | " + errorThrown);
                        });
                 
             }
         }
         alert("complete function ended");
         
     }
     $(document).ready(function(){
         $("#add-task-button").click(addTask);
         $("#complete-checked").click(completeChecked);
     });
    </script>
@endsection
