<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
}
