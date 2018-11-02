<?php

namespace App\Http\Controllers;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /*
       Create a new task
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'authorId' => 'required'
        ]);
        // Create The Task...
        // :) So this is the ORM 
        $task = new Task();
        $task->name = $request->name;
        $task->authorId = $request->authorId;
        $task->description = "";
        $task->parentTaskListId = $request->taskListId;
        $task->save();

        return ['response' => 'success'];
    }
    public function complete(Request $request)
    {
        $this->validate($request, [
            'taskId' => 'required'
        ]);
        $taskId = $request->taskId;
        DB::table('tasks')
          ->where('id', $taskId)
          ->update(['completed' => true]);

        return ['response' => 'success'];
        
    }
}
