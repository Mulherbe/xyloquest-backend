<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskComment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'content'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
