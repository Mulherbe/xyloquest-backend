<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'task_status_id' => TaskStatus::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => now()->addDays(3),
            'position' => 0,
            'points' => 1,
            'is_completed' => false,
        ];
    }
}
