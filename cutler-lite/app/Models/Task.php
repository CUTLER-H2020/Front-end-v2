<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
    protected $fillable = [
        'user_id',
        'xml_task_name',
        'xml_task_id',
        'xml_process_id',
        'process_name',
        'phase',
        'instance_id',
    ];

    public function process()
    {
        return $this->hasOne(Process::class, 'xml_process_id', 'xml_process_id');
    }

    /**
     * @return HasMany
     */
    public function widgets(): HasMany
    {
        return $this->hasMany(NewWidget::class);
    }

}
