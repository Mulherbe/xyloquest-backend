<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $year
 * @property int $month
 * @property int $goal_points
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\MonthlyGoalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereGoalPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MonthlyGoal whereYear($value)
 * @mixin \Eloquent
 */
class MonthlyGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'month',
        'goal_points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
