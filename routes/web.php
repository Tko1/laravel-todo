<?php
use App\Task;
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

Route::get('/', function () {
    return view('home');
});

Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'authorId' => 'required|integer'
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // Create The Task...
    // :) So this is the ORM 
    $task = new Task;
    $task->name = $request->name;
    $task->authorId = $request->authorId;
    $task->save();

    return redirect('/');
});

Route::delete('/task/{id}', function($id){
    //
});
