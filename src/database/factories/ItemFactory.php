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
        $item = [
            'seller_id' => User::factory()->create()->id,
            'buyer_id' => null,
            'category_id' => Category::inRandomOrder()->first()->id,
            'condition_id' => Condition::inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'brand' => $this->faker->company,
            'price' => $this->faker->numberBetween(100, 99999),
            'description' => $this->faker->paragraph,
        ];

        // Item インスタンスを保存
        $createdItem = Item::create($item);

        // 画像データを関連付けて保存
        $createdItem->images()->create([
            'image_url' => asset('image/' . rand(1, 10) . '.png'), // ダミー画像のURL
            'is_top' => true
        ]);

        return $item;
    }

}

