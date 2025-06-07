<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
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

    public function test_can_list_taskstatuss(): void
    {
        TaskStatus::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/task-status');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_taskstatus(): void
    {
        $payload = ['name' => 'À faire', 'order' => 1];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/task-status', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'À faire');
    }

    public function test_can_show_taskstatus(): void
    {
        $item = TaskStatus::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/task-status/{$item->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $item->id);
    }

    public function test_can_update_taskstatus(): void
    {
        $item = TaskStatus::factory()->create();

        $updateData = ['name' => 'Nouveau statut', 'order' => 2];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/task-status/{$item->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Nouveau statut');
    }

    public function test_can_delete_taskstatus(): void
    {
        $item = TaskStatus::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/task-status/{$item->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'TaskStatus deleted successfully.']);
    }
}
