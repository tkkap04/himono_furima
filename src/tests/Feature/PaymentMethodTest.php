<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_payment_method()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/change/method', [
            'method' => 'クレジットカード'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'payment_method' => 'クレジットカード'
        ]);
    }
}
