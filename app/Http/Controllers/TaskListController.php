<?php

namespace App\Http\Controllers;

use App\TaskList;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'authorId' => 'required'
        ]);
        
        $taskList = new TaskList();
        $taskList->authorId = $request->authorId;
        $taskList->name = $request->name;
        $taskList->save();

        return ['response' => 'success'];
    }
    public function fetch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        
        $response = [ 'response' => 'failure'];

        $id = $request->id;
        $taskList = TaskList::where('id','=',$id)->first();

        if ($taskList === null) {
            $response['response'] = 'failure';
        }
        else {
            $taskListId = $taskList->id;
            $taskListName = $taskList->name;
            
            $response['response'] = 'success';
            //Load this task list as the active taskList of this session
            $request->session()->put('taskListId',$taskListId);
            //Change task list name
            $request->session()->put('taskListName',$taskListName);
        }
        return $response;
    }
}
