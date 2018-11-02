<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    //
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
