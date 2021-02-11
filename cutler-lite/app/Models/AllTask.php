<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllTask extends Model
{
    protected $table = "all_tasks";

    protected $fillable = ["status", "phase", "finished_at", "started_at"];

    public function process()
    {
        return $this->hasOne(Process::class, 'xml_instance_id', 'instance_id');
    }
}
