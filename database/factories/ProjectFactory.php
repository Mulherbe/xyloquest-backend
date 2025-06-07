<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'goal_points' => $this->faker->numberBetween(50, 200),
            'current_points' => $this->faker->numberBetween(0, 50),
            'is_completed' => $this->faker->boolean(10), // 10% chance true
        ];
    }
}
