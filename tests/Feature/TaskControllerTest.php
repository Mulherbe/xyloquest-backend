<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;
    protected Project $project;
    protected TaskStatus $status;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test')->plainTextToken;
        $this->project = Project::factory()->create();
        $this->status = TaskStatus::factory()->create(['name' => 'À faire', 'order' => 1]);
    }

    protected function authHeaders(): array
    {
        return ['Authorization' => "Bearer {$this->token}"];
    }

    public function test_can_list_tasks(): void
    {
        Task::factory()->create([
            'project_id' => $this->project->id,
            'task_status_id' => $this->status->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/tasks');

        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_can_create_task(): void
    {
        $payload = [
            'project_id' => $this->project->id,
            'task_status_id' => $this->status->id,
            'title' => 'Nouvelle tâche',
            'description' => 'Contenu',
            'due_date' => now()->addDays(3)->toDateTimeString(),
            'points' => 2,
            'position' => 0,
            'is_completed' => false
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/tasks', $payload);

        $response->assertStatus(201)->assertJsonPath('data.title', 'Nouvelle tâche');
    }

    public function test_can_show_task(): void
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'task_status_id' => $this->status->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)->assertJsonPath('data.id', $task->id);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'task_status_id' => $this->status->id,
        ]);

        $updateData = ['title' => 'Titre mis à jour'];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)->assertJsonPath('data.title', 'Titre mis à jour');
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'task_status_id' => $this->status->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)->assertJson(['message' => 'Task deleted successfully.']);
    }
}
