<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ConditionSeeder::class,
            PaymentMethodSeeder::class,
        ]);

        \App\Models\Item::factory(11)->create();
    }
}
