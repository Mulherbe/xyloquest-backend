<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $activity_type_id
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property bool $is_recurring
 * @property string|null $recurrence_rule
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string $status
 * @property int $earned_points
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ActivityType $activityType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Log> $logs
 * @property-read int|null $logs_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ActivityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereActivityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereEarnedPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereRecurrenceRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUserId($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE = 'done';
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
        'earned_points',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'completed_at' => 'datetime',
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
