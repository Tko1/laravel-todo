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
    $userId = $request->session()->get('userId');
    $taskListId = $request->session()->get('taskListId');
    //TODO get tasks one time,  then pull out completed?
    $tasks = Task::where('authorId', '=', $userId)
                 ->where('parentTaskListId', '=', $taskListId)
                 ->where('completed', '=', false)
                 ->orderBy('created_at', 'asc')->get();
    
    $completedTasks = Task::where('authorId', '=', $userId)
                          ->where('parentTaskListId', '=', $taskListId)
                          ->where('completed', '=', true)
                          ->orderBy('created_at', 'asc')->get();
    $profiles = Profile::all()->pluck('name')->toArray();
    return view('home', [
        'tasks' => $tasks,
        'completedTasks' => $completedTasks,
        'profiles' => $profiles
    ]);
});

Route::delete('/task/{id}', function($id){
    //
});
// TODO change all 'names' to be 'usernames' for consistency
Route::post('/createProfile',function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    if ($validator->fails()) {
        return redirect('/')
->withInput()
->withErrors($validator);
    }
    /* 
       Hmm ..  I'm repeating myself here,
       there's got to be a way to automate this a bit
     */
    $profile = new Profile();
    $profile->name = $request->name;
    $profile->save();

    /*
     * Create an empty taskList for our new profile
     */
    $taskList = new TaskList();
    $taskList->authorId = $profile->id;
    $taskList->name = "Default Task List";
    $taskList->save();
    
    return [ 'response' => 'success', 'username' => $profile->name, 'userId' => $profile->id];
});

Route::post('/createTask', 'TaskController@store');
Route::post('/completeTask', 'TaskController@complete');
Route::post('/login',function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);
    
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $response = [ 'response' => 'failure'];
    $loginName = $request->name;

    //Check to see if valid profile name
    $profile = Profile::where('name', '=', $loginName)->first();
    if ($profile === null) {
        $response['response'] = 'failure';
    }
    else {
        $loginId = $profile->id;

        //Load first task list user has
        $taskList = TaskList::where('authorId', '=', $loginId)->first();
        
        if ($taskList === null) {
            $response['response'] = 'failure';
            return $response;
        }
        $taskListId = $taskList->id;
        $taskListName = $taskList->name;
        //We will be telling our caller it worked out, and the profile
        //name
        $response['response'] = 'success';
        $response['username'] = $loginName;
        $request->session()->put('username',$loginName);
        $request->session()->put('userId',$loginId);
        //Load this task list as the active taskList of this session
        $request->session()->put('taskListId',$taskListId);
        //Change task list name
        $request->session()->put('taskListName',$taskListName);
    }
    return $response;
});
