<?php

namespace Tests\Feature;

use App\Models\ActivityType;
use App\Models\User;
use Tests\TestCase;

class ActivityTypeControllerTest extends TestCase
{

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

    public function test_authenticated_user_can_list_activity_types()
    {
        ActivityType::factory()->count(2)->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/activity-types');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_authenticated_user_can_create_activity_type()
    {
        $payload = [
            'name' => 'Travail',
            'color' => '#FF00FF',
            'default_points_per_hour' => 4,
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/activity-types', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Travail')
                 ->assertJsonPath('data.default_points_per_hour', 4);
    }

    public function test_authenticated_user_can_show_activity_type()
    {
        $type = ActivityType::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/activity-types/{$type->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $type->id);
    }

    public function test_authenticated_user_can_update_activity_type()
    {
        $type = ActivityType::factory()->create([
            'name' => 'Ancien',
            'default_points_per_hour' => 2,
        ]);

        $update = [
            'name' => 'Mis à jour',
            'default_points_per_hour' => 6,
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/activity-types/{$type->id}", $update);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Mis à jour')
                 ->assertJsonPath('data.default_points_per_hour', 6);
    }

    public function test_authenticated_user_can_delete_activity_type()
    {
        $type = ActivityType::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/activity-types/{$type->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('activity_types', ['id' => $type->id]);
    }
}
