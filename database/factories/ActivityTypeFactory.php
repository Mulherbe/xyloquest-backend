<?php

namespace Database\Factories;

use App\Models\ActivityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityTypeFactory extends Factory
{
    protected $model = ActivityType::class;

    public function definition(): array
    {
            return [
            'name' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'default_points_per_hour' => 4, // ⚠️ c’est ça qui compte
        ];

    }
}
