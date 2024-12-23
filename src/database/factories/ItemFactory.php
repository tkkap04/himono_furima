<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'seller_id' => User::factory()->create()->id,
            'buyer_id' => null,
            'category_id' => Category::inRandomOrder()->first()->id,
            'condition_id' => Condition::inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'brand' => $this->faker->company,
            'price' => $this->faker->numberBetween(100, 99999),
            'description' => $this->faker->paragraph,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            $randomImage = 'image/' . rand(1, 10) . '.png';
            $item->images()->create([
                'image_url' => $randomImage,
                'is_top' => true,
            ]);
        });
    }
}
