<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;
    protected ActivityType $type;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();

        /** @var ActivityType $type */
        $type = ActivityType::factory()->create([
            'default_points_per_hour' => 4,
        ]);

        $this->user = $user;
        $this->token = $user->createToken('test')->plainTextToken;
        $this->type = $type;
    }

    protected function authHeaders(): array
    {
        return ['Authorization' => "Bearer {$this->token}"];
    }

    public function test_can_list_activities(): void
    {
        Activity::factory()->create([
            'user_id' => $this->user->id,
            'activity_type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson('/api/activities');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_can_create_activity_and_calculate_points(): void
    {
        /** @var Carbon $start */
        $start = Carbon::now();
        $end = (clone $start)->addHour();

        $payload = [
            'title' => 'Test activité',
            'description' => 'Description',
            'user_id' => $this->user->id,
            'start_date' => $start->toDateTimeString(),
            'end_date' => $end->toDateTimeString(),
            'is_recurring' => false,
            'recurrence_rule' => null,
            'completed_at' => null,
            'activity_type_id' => $this->type->id,
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->postJson('/api/activities', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.earned_points', 4);
    }

    public function test_can_show_activity(): void
    {
        /** @var Activity $activity */
        $activity = Activity::factory()->create([
            'user_id' => $this->user->id,
            'activity_type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->getJson("/api/activities/{$activity->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $activity->id);
    }

    public function test_can_update_activity_and_recalculate_points(): void
    {
        /** @var Carbon $start */
        $start = Carbon::now();

        /** @var Activity $activity */
        $activity = Activity::factory()->create([
            'user_id' => $this->user->id,
            'activity_type_id' => $this->type->id,
            'start_date' => $start,
            'end_date' => (clone $start)->addMinutes(30),
        ]);

        $updateData = [
            'end_date' => (clone $start)->addHours(2)->toDateTimeString(),
        ];

        $response = $this->withHeaders($this->authHeaders())
                         ->putJson("/api/activities/{$activity->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.earned_points', 8);
    }

    public function test_can_delete_activity_and_return_updated_monthly_points(): void
    {
        /** @var Carbon $start */
        $start = Carbon::now();

        /** @var Activity $activity */
        $activity = Activity::factory()->create([
            'user_id' => $this->user->id,
            'activity_type_id' => $this->type->id,
            'start_date' => $start,
            'end_date' => (clone $start)->addHour(),
            'earned_points' => 4,
        ]);

        $response = $this->withHeaders($this->authHeaders())
                         ->deleteJson("/api/activities/{$activity->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Activity deleted successfully.',
                     'updated_monthly_points' => 0,
                 ]);
    }
}
