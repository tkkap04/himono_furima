<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'convenience_store']),
        ];
    }
}
