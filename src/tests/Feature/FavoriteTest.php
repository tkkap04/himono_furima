<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_to_favorites()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);
        $response = $this->post('/favorite', ['item_id' => $item->id]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('favorite', ['user_id' => $user->id, 'item_id' => $item->id]);
    }

    public function test_remove_item_from_favorites()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->favorite()->attach($item->id);

        $this->actingAs($user);
        $response = $this->delete('/favorite/' . $item->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorite', ['user_id' => $user->id, 'item_id' => $item->id]);
    }

    public function test_get_favorite_items()
    {
        $user = User::factory()->create();
        $items = Item::factory(3)->create();
        $user->favorite()->attach($items);

        $this->actingAs($user);
        $response = $this->get('/favorite');

        $response->assertStatus(200)->assertJsonCount(3);
    }
}
