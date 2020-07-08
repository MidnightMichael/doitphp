<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $primaryKey = 'task_id';

    protected  $fillable = [
        'task_name',
        'task_status',
        'task_owner',
    ];
}
