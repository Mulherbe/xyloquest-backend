<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_logs()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/logs');

        // Doit retourner 200 OK avec les logs d'activité
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }
}
