<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function taskLists()
    {
        return $this->hasMany(TaskList::class);
    }
}
