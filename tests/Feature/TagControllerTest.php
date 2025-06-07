<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
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

    public function test_can_list_tags(): void
    {
        Tag::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/tags');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_tag(): void
    {
        $payload = [
            'name' => 'Tag test',
            'color' => '#ff0000'
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/tags', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Tag test');
    }

    public function test_can_show_tag(): void
    {
        $item = Tag::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/tags/{$item->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $item->id);
    }

    public function test_can_update_tag(): void
    {
        $item = Tag::factory()->create(['name' => 'Ancien tag', 'color' => '#123456']);

        $updateData = [
            'name' => 'Tag modifié',
            'color' => '#00ff00'
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/tags/{$item->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', $updateData['name']);
    }

    public function test_can_delete_tag(): void
    {
        $item = Tag::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/tags/{$item->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Tag deleted successfully.']);
    }
}
