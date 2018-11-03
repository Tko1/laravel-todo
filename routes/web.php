<?php
use App\Task;
use App\Profile;
use App\TaskList;
use Illuminate\Http\Request;
/*
   |--------------------------------------------------------------------------
   | Web Routes
   |--------------------------------------------------------------------------
   |
   | Here is where you can register web routes for your application. These
   | routes are loaded by the RouteServiceProvider within a group which
   | contains the "web" middleware group. Now create something great!
   |
 */

Route::get('/', function (Request $request) {
    //Get our current user id
    $userId = $request->session()->get('userId');
    //Get our current task list id
    $taskListId = $request->session()->get('taskListId');
    /*
       Get all the (incomplete) tasks that belong to this user
       to show in the active task list window,and narrow them down
       to tasks that should be a part of the active task list.
       Note: may be better to just query for task list's tasks, since 
       the task list belongs to the user and, transitively, 
       the tasks would as well
     */
    $tasks = Task::where('authorId', '=', $userId)
                 ->where('parentTaskListId', '=', $taskListId)
                 ->where('completed', '=', false)
                 ->orderBy('created_at', 'asc')->get();
    //Get all complete tasks for the completed tasks window
    $completedTasks = Task::where('authorId', '=', $userId)
                          ->where('parentTaskListId', '=', $taskListId)
                          ->where('completed', '=', true)
                          ->orderBy('created_at', 'asc')->get();
    //Get a list of profile names for the profile view window
    $profiles = Profile::all()->pluck('name')->toArray();
    
    //Get a list of the tasks lists for the task list
    //bar switcher at the bottom
    $taskLists = TaskList::where('authorId', '=', $userId)
                         ->orderBy('created_at', 'asc')->get();
    //Pass all our information to our view
    return view('home', [
        'tasks' => $tasks,
        'completedTasks' => $completedTasks,
        'profiles' => $profiles,
        'taskLists' => $taskLists
    ]);
});

// TODO change all 'names' to be 'usernames' for consistency
Route::post('/createProfile','ProfileController@store');
Route::post('/login','ProfileController@fetch');

Route::post('/createTask', 'TaskController@store');
Route::post('/completeTask', 'TaskController@complete');

//Not sure the best way to format this 
Route::post('/createTaskList','TaskListController@store'
)->name('createTaskList');

Route::post('/switchTaskList','TaskListController@fetch');
