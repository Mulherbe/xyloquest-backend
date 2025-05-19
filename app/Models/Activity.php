<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE    = 'done';
    public const STATUS_SKIPPED = 'skipped';

    protected $fillable = [
        'user_id',
        'activity_type_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_recurring',
        'recurrence_rule',
        'completed_at',
        'status', 
        'earned_points'
    ];

    protected $casts = [
        'is_recurring'  => 'boolean',
        'start_date'    => 'datetime',
        'end_date'      => 'datetime',
        'completed_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
    public function isDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }
        public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
    public function isSkipped(): bool
    {
        return $this->status === self::STATUS_SKIPPED;
    }
}
