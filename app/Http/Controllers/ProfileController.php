<?php

namespace App\Http\Controllers;

use App\Profile;
use App\TaskList;
//use App\Http\Controllers
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);
        /* 
           Hmm ..  I'm repeating myself here,
           there's got to be a way to automate this a bit
         */
        $profile = new Profile();
        $profile->name = $request->name;
        $profile->save();

        /*
         * Is this the best way to reuse this behavior? 
         */
        $taskList = new TaskList();
        $taskList->authorId = $profile->id;
        $taskList->name = "Default Task List";
        $taskList->save();
        /*
           Things I tried: 
           app('App\Http\Controllers\TaskListController')->store(
           
           
           redirect()->route('createTaskList',[
           'authorId' => $profile->id,
           'name'     => "Default Task List"
           ]);
           
         */            
        return [ 'response' => 'success'];
        
    }

    public function fetch(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

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
        

    }
}
