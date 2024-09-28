<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PreferenceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_a_user_can_set_preferences()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/preferences', [
            'authors' => ['John Doe', 'Jane Smith'],
            'categories' => ['Technology', 'Science'],
            'sources' => ['NewsAPI', 'BBC'],
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('preferences', ['user_id' => $user->id]);
    }

    /**
     * @return void
     */
    public function test_it_can_fetch_user_preferences()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')->postJson('/api/preferences', [
            'authors' => ['John Doe'],
            'categories' => ['Technology'],
            'sources' => ['NewsAPI'],
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/preferences');

        $response->assertOk();
        $response->assertJsonFragment([
            'authors' => ['John Doe'],
            'categories' => ['Technology'],
            'sources' => ['NewsAPI'],
        ]);
    }
}
