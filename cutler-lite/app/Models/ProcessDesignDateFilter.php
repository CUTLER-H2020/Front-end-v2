<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessDesignDateFilter extends Model
{
    protected $table = "process_design_date_filters";

    protected $fillable = ['xml_process_id', 'xml_process_name', 'xml_process_key', 'task_name', 'start_date', 'end_date', 'last_selection'];
}
