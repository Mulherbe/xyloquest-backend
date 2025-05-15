<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_activities()
    {
        // Crée un utilisateur et un token
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        // Envoie une requête GET à /api/activities
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/activities');

        // Doit retourner 200 OK avec un tableau de résultats
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }
}
