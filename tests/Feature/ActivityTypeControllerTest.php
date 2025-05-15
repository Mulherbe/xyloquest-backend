<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_activity_types()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/activity-types');

        // Doit retourner 200 OK avec les types d'activités
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }
}
