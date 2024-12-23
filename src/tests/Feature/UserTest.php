<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_information()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/user');

        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id, 'email' => $user->email]);
    }

    public function test_get_user_purchased_items()
    {
        $user = User::factory()->create();
        $items = Item::factory(3)->create(['buyer_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/user/purchases');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_get_user_selling_items()
    {
        $user = User::factory()->create();
        $items = Item::factory(2)->create(['seller_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/user/selling');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
}
