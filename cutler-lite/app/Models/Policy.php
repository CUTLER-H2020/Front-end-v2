<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = "policies";

    public function startedProcesses()
    {
        return $this->hasMany('App\Models\Process', 'policy_id', 'id')->where('started', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
