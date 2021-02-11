<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewWidget
 * @package App\Models
 */
class NewWidget extends Model
{
    protected $fillable = [
        'user_id',
        'xml_process_id',
        'xml_process_name',
        'xml_process_key',
        'task_name',
        'task_phase',
        'widget_id',
        'widget_type',
        'widget_title',
        'widget_name',
        'dashboard_id',
        'dashboard_title',
    ];
}
