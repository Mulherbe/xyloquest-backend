<?php

namespace Database\Factories;

use App\Models\MonthlyGoal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyGoalFactory extends Factory
{
    protected $model = MonthlyGoal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // crée un user automatiquement si non précisé
            'year' => $this->faker->year(),
            'month' => $this->faker->numberBetween(1, 12),
            'goal_points' => $this->faker->numberBetween(50, 200),
        ];
    }
}
