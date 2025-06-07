<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskItem extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'title', 'is_done'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
