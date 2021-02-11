<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $table = "task_comments";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
