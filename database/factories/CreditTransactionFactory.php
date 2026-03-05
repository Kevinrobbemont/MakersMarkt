<?php

namespace Database\Factories;

use App\Models\CreditTransaction;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreditTransaction>
 */
class CreditTransactionFactory extends Factory
{
    protected $model = CreditTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_user_id' => User::factory(),
            'to_user_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 5, 75),
            'order_id' => Order::factory(),
        ];
    }
}
