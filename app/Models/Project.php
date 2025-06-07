<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'goal_points', 'current_points', 'is_completed',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
