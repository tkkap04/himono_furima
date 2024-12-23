<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/profile', [
            'username' => 'UpdatedName',
            'address' => '123 Test Street',
            'postal_code' => '1234567',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'UpdatedName',
            'address' => '123 Test Street',
            'postal_code' => '1234567',
        ]);
    }
}
