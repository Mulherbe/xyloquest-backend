<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'task_status_id', 'title', 'description', 'due_date',
        'position', 'activity_id', 'points', 'is_completed',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function checklist()
    {
        return $this->hasMany(TaskItem::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
