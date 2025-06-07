<?php

namespace Database\Factories;

use App\Models\TaskItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskItemFactory extends Factory
{
    protected $model = TaskItem::class;

    public function definition(): array
    {
        return [
            'task_id' => \App\Models\Task::factory(),
            'title' => $this->faker->sentence(3),
            'is_done' => $this->faker->boolean(20), // 20% chance true
        ];
    }
}
