<?php

namespace Tests\Feature;

use App\Models\TaskItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskItemControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    protected function authHeaders(): array
    {
        return ['Authorization' => "Bearer {$this->token}"];
    }

    public function test_can_list_taskitems(): void
    {
        TaskItem::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/task-items');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_taskitem(): void
    {
        // Un TaskItem a besoin d'un task_id valide
        $task = \App\Models\Task::factory()->create();
        $payload = [
            'task_id' => $task->id,
            'title' => 'Nouvel item',
            'is_done' => false
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/task-items', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.title', 'Nouvel item');
    }

    public function test_can_show_taskitem(): void
    {
        $item = TaskItem::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/task-items/{$item->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $item->id);
    }

    public function test_can_update_taskitem(): void
    {
        $item = TaskItem::factory()->create();

        $updateData = ['title' => 'Item modifié', 'is_done' => true];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/task-items/{$item->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.title', 'Item modifié')
                 ->assertJsonPath('data.is_done', true);
    }

    public function test_can_delete_taskitem(): void
    {
        $item = TaskItem::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/task-items/{$item->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'TaskItem deleted successfully.']);
    }
}
