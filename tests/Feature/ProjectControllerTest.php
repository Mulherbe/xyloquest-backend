<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
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

    public function test_can_list_projects(): void
    {
        Project::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/projects');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_project(): void
    {
        $payload = [
            'name' => 'Projet test',
            'description' => 'Description test',
            'goal_points' => 100,
            'current_points' => 0,
            'is_completed' => false
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/projects', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Projet test');
    }

    public function test_can_show_project(): void
    {
        $item = Project::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/projects/{$item->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $item->id);
    }

    public function test_can_update_project(): void
    {
        $item = Project::factory()->create();

        $updateData = [
            'name' => 'Projet modifié',
            'description' => 'Description modifiée',
            'goal_points' => 200,
            'current_points' => 10,
            'is_completed' => true
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/projects/{$item->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Projet modifié');
    }

    public function test_can_delete_project(): void
    {
        $item = Project::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/projects/{$item->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Project deleted successfully.']);
    }
}
