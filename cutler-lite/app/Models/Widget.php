<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $table = "widgets";

    public function task()
    {
        return $this->hasOne('App\Models\Task', 'xml_task_id', 'task_id');
    }
}
