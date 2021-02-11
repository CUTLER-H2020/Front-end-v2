<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = "processes";

    protected $fillable = ['user_id', 'xml_process_id', 'policy_id', 'xml_process_name', 'policy_id', 'policy_name', 'started', 'started_at', 'completed', 'completed_at'];

    public function policy()
    {
        return $this->hasOne('App\Models\Policy', 'id', 'policy_id');
    }

    public function activeTask()
    {
        return $this->hasOne('App\Models\Task', 'instance_id', 'xml_instance_id');
    }

    public function allTasks()
    {
        return $this->hasMany('App\Models\AllTask', 'instance_id', 'xml_instance_id');
    }

    public function createdUser()
    {
        return $this->hasOne(User::class, 'id','created_user_id');
    }

    public function startedUser()
    {
        return $this->hasOne(User::class, 'id','started_user_id');
    }
}
