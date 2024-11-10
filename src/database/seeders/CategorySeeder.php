<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {   // メインカテゴリー
        $clothingId = Category::firstOrCreate(['name' => 'ファッション'], ['parent_id' => null])->pluck('id')->first();
        $kidsId = Category::firstOrCreate(['name' => 'キッズ'], ['parent_id' => null])->pluck('id')->first();
        $electronicsId = Category::firstOrCreate(['name' => '家電'], ['parent_id' => null])->pluck('id')->first();
        $furnitureId = Category::firstOrCreate(['name' => '家具'], ['parent_id' => null])->pluck('id')->first();
        $gamesId = Category::firstOrCreate(['name' => 'ゲーム'], ['parent_id' => null])->pluck('id')->first();

        // サブカテゴリ
        Category::firstOrCreate(['name' => 'メンズ', 'parent_id' => $clothingId]);
        Category::firstOrCreate(['name' => 'レディース', 'parent_id' => $clothingId]);

        // 家電のサブカテゴリ
        Category::firstOrCreate(['name' => '冷蔵庫', 'parent_id' => $electronicsId]);
        Category::firstOrCreate(['name' => '洗濯機', 'parent_id' => $electronicsId]);
        Category::firstOrCreate(['name' => 'テレビ', 'parent_id' => $electronicsId]);
        Category::firstOrCreate(['name' => 'エアコン', 'parent_id' => $electronicsId]);
        Category::firstOrCreate(['name' => 'レンジ', 'parent_id' => $electronicsId]);

        // 家具のサブカテゴリ
        Category::firstOrCreate(['name' => 'ベッド', 'parent_id' => $furnitureId]);
        Category::firstOrCreate(['name' => 'テーブル', 'parent_id' => $furnitureId]);
        Category::firstOrCreate(['name' => 'いす', 'parent_id' => $furnitureId]);
        Category::firstOrCreate(['name' => '机', 'parent_id' => $furnitureId]);
        Category::firstOrCreate(['name' => 'チェスト', 'parent_id' => $furnitureId]);
        Category::firstOrCreate(['name' => '食器棚', 'parent_id' => $furnitureId]);

        // ゲームのサブカテゴリ
        Category::firstOrCreate(['name' => '本体', 'parent_id' => $gamesId]);
        Category::firstOrCreate(['name' => 'ソフト', 'parent_id' => $gamesId]);
        Category::firstOrCreate(['name' => '周辺機器', 'parent_id' => $gamesId]);

        // キッズのサブカテゴリ
        Category::firstOrCreate(['name' => '服', 'parent_id' => $kidsId]);
        Category::firstOrCreate(['name' => 'おもちゃ', 'parent_id' => $kidsId]);
        Category::firstOrCreate(['name' => '衛生用品', 'parent_id' => $kidsId]);
    }
}
