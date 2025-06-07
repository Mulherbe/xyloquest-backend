<?php

namespace Tests\Feature;

use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCommentControllerTest extends TestCase
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

    public function test_can_list_taskcomments(): void
    {
        TaskComment::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/task-comments');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_taskcomment(): void
    {
        $task = \App\Models\Task::factory()->create();
        $payload = [
            'task_id' => $task->id,
            'content' => 'Un commentaire de test.'
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/task-comments', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.content', 'Un commentaire de test.');
    }

    public function test_can_show_taskcomment(): void
    {
        $item = TaskComment::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/task-comments/{$item->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $item->id);
    }

    public function test_can_update_taskcomment(): void
    {
        $item = TaskComment::factory()->create();

        $updateData = [
            'content' => 'Commentaire modifié.'
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/task-comments/{$item->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.content', 'Commentaire modifié.');
    }

    public function test_can_delete_taskcomment(): void
    {
        $item = TaskComment::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/task-comments/{$item->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'TaskComment deleted successfully.']);
    }
}
