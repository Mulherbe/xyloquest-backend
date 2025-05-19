<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 week', 'now');
        $end = (clone $start)->modify('+1 hour');
        
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'activity_type_id' => ActivityType::factory(),
            'start_date' => $start,
            'end_date' => $end,
            'is_recurring' => false,
            'recurrence_rule' => null,
            'completed_at' => null,
            'status' => 'pending',
            'earned_points' => 4,
        ];
    }
}
