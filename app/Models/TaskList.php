<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
    use softDeletes;
    protected $primaryKey = 'task_list_id';

    protected $fillable = [
        'task_list_name',
        'task_list_owner',
        'task_list_deadline',
        'task_list_color',
        'task_list_uniform_name',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_owner', 'task_list_id');
    }
}
