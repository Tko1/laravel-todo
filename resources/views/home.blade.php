@extends('layout')

<!--Built on top of the sample here https://bootsnipp.com/snippets/featured/todo-example  -->
@section('head')
    {{ Html::style('css/home.css') }}
    
@endsection

@section('content')
    <script>
     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     function refreshHome()
     {
         $("#body-reload-wrapper").load("/ #body-reload-wrapper");
     }
     function addTask() {
         console.log("start: addTask");
         let taskName = $('#add-task-input').val();
         let userId   = $('.user-meta')[0].getAttribute("userId");
         let taskListId = $('.user-meta')[0].getAttribute("taskListId");
         $.post("/createTask", { _token : CSRF_TOKEN,
                                 "name" : taskName,
                                 "authorId" : userId,
                                 "taskListId" : taskListId},
                function(result){
                    console.log(result);
                    console.log("create task success! " + name);
                    refreshHome();
                }).fail(function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    console.log(" | " + textStatus + " | " + errorThrown);
                });
         console.log("addTask function ended");
         
     }
     function addTaskList(){
         console.log("start: addTaskList");
         let taskName = $('#add-tasklist-input').val();
         let userId   = $('.user-meta')[0].getAttribute("userId");
         console.log("Name: " +taskName+ " userId: " + userId);
         $.post("/createTaskList", { _token : CSRF_TOKEN,
                                     "name" : taskName,
                                     "authorId" : userId},
                function(result){
                    console.log(result);
                    console.log("create tasklist success! " + name);
                    refreshHome();
                }).fail(function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    console.log(" | " + textStatus + " | " + errorThrown);
                });
         console.log("addTask function ended");
         
     }
     function switchTaskList(){
         console.log("start: switchTaskList");
         let taskListId = $(this)[0].getAttribute("taskList-id");
         console.log("taskListId " + taskListId);
         console.log($(this)[0]);
         $.post("/switchTaskList", { _token : CSRF_TOKEN,
                                     "id" : taskListId},
                function(result){
                    console.log(result);
                    console.log("switchTaskList success! ");
                    refreshHome();
                }).fail(function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    console.log(" | " + textStatus + " | " + errorThrown);
                });
         console.log("switchTasklist function ended");
         
     }
     function completeChecked()
     {
         //task-list-item
         console.log("start: completeChecked");
         let taskLabels = document.getElementsByClassName("task-label");
         let labelCount = taskLabels.length;
         for (let i = 0; i < labelCount; i++) {
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
                            console.log(result);
                            refreshHome();
                        }).fail(function(xhr, textStatus, errorThrown) {
                            console.log(xhr);
                            console.log(" | " + textStatus + " | " + errorThrown);
                        });
                 
             }
         }
         console.log("complete function ended");
         
     }
     $(document).on('click',"#add-task-button",addTask);
     $(document).on('click',"#complete-checked",completeChecked);
     $(document).on('click',".load-profile-li",
                    function() {
                        let name = $(this).text();
                        console.log($(this));
                        console.log("name! " + name);
                        loadProfile(name);
                        refreshHome();
                    });
     $(document).on('click',"#new-taskList-button",addTaskList);
     $(document).on('click',".taskList-nav-link",switchTaskList);
     
    </script>
    <!--  Modal for creating task list------------------------------>
    <div class="modal fade" id="modalTaskListForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">New Tasklist</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body mx-3">
                        <div class="md-form mb-5">
                            
                            <input type="username" id="add-tasklist-input" class="form-control validate" placeholder="Username">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-default" id="new-taskList-button">
                            Add Tasklist
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------- -->
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
                <div class="finished-todolist">
                    <h1>Already Done</h1>
                    <ul id="done-items" class="list-unstyled finished-todolist-list">
                        @foreach($completedTasks as $completedTask)
                            <li>{{ $completedTask->name }}</li>
                        @endforeach
                    </ul>
                    
                    
                </div>
                <div class="jumbotron user-profile-box">
                    <div style="position: relative;">
                        <span style="float: left;">
                            <img src="/images/defaultProfile.jpg" height="100" width="100">
                        </span>
                        <!-- Until I know the proper way, this is how I will store certain information to pass to javascript so that jquery.load will load new Session variables as well -->
                        <span>
                            <!--  Currently have this on one line due to small error with whitespace (will trim later)-->
                            <h3 class="user-meta"
                                username="{{Session::get('username') ?: "No profile loaded"}}"
                                userId="{{Session::get('userId') ?: 0}}"
                                taskListId="{{Session::get('taskListId')}}">{{ Session::get('username') ?: "No profile loaded" }}</h3>
                        </span>
                    </div>
                    <hr>
                    <p> User profiles: </p>
                    
                    <div class="list-group user-profile-list">
                        @foreach($profiles as $profile)
                            <a href="#" class="list-group-item load-profile-li lg-hover">{{$profile}}</a>
                        @endforeach
                    </div>
                    <hr class="my-2">
                    <div class="text-center">
                        <button href="" class="btn" data-toggle="modal" data-target="#modalLoginForm">Add profile</button>
                    </div>
                </div>
            </div>
        </div>
@endsection


@section('footer')
    <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="#">{{Session::get("username") ?: "Add profile to use todo list!"}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                @foreach($taskLists as $taskList)
                    <li class="nav-item active">
                        <a class="nav-link taskList-nav-link" href="javascript:;" taskList-id="{{$taskList->id}}" >{{$taskList->name}} <span class="sr-only"></span></a>
                    </li>
                @endforeach
                
                <li class="nav-item">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-number circle"  data-toggle="modal" data-target="#modalTaskListForm">
                            <i class='fa fa-plus'></i>
                        </button>
                    </span>
                </li>
            </ul>
        </div>
    </nav>
    
@endsection
