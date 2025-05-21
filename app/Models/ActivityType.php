<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property int $default_points_per_hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Database\Factories\ActivityTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereDefaultPointsPerHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'default_points_per_hour',
    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
