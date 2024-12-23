<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);
        $this->artisan('db:seed', ['--class' => 'ConditionSeeder']);
    }

    public function test_get_item_list()
    {
        Item::factory(5)->create();

        $response = $this->get('/items');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_get_item_details()
    {
        $item = Item::factory()->create();

        $response = $this->get('/items/' . $item->id);

        $response->assertStatus(200)
                 ->assertJson(['id' => $item->id, 'name' => $item->name]);
    }

}
