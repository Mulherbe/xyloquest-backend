<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_recurring',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
