<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = ['クレジットカード', '銀行振り込み', 'コンビニ払い'];

        foreach ($methods as $method) {
            PaymentMethod::create(['name' => $method]);
        }
    }
}
