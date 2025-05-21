<?php

namespace Tests\Feature;

use App\Models\MonthlyGoal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonthlyGoalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();

        $this->user = $user;
        $this->token = $user->createToken('test')->plainTextToken;
    }

    protected function authHeaders(): array
    {
        return ['Authorization' => "Bearer {$this->token}"];
    }

    public function test_can_list_monthly_goals(): void
    {
        /** @var MonthlyGoal $goal */
        $goal = MonthlyGoal::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/monthly-goals');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_or_update_monthly_goal(): void
    {
        $payload = [
            'user_id' => $this->user->id,
            'year' => 2025,
            'month' => 5,
            'goal_points' => 100,
        ];
        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/monthly-goals', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.user_id', $this->user->id)
                 ->assertJsonPath('data.goal_points', 100);
    }

    public function test_can_show_monthly_goal(): void
    {
        /** @var MonthlyGoal $goal */
        $goal = MonthlyGoal::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/monthly-goals/{$goal->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $goal->id);
    }

    public function test_can_update_monthly_goal(): void
    {
        /** @var MonthlyGoal $goal */
        $goal = MonthlyGoal::factory()->create([
            'user_id' => $this->user->id,
            'goal_points' => 100,
        ]);

        $updateData = [
            'goal_points' => 200,
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/monthly-goals/{$goal->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.goal_points', 200);
    }

    public function test_can_delete_monthly_goal(): void
    {
        /** @var MonthlyGoal $goal */
        $goal = MonthlyGoal::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/monthly-goals/{$goal->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('monthly_goals', ['id' => $goal->id]);
    }
}
