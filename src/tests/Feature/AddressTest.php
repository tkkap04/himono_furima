<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_shipping_address()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/change/place', [
            'address' => '456 New Street',
            'postal_code' => '9876543',
            'building' => 'Test Building'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'address' => '456 New Street',
            'postal_code' => '9876543',
            'building' => 'Test Building',
        ]);
    }
}
