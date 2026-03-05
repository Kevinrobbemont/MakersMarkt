<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Credit;
use App\Models\CreditTransaction;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Report;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class MakersMarktSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $makerRole = Role::firstOrCreate(['name' => 'maker']);
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        $categories = collect([
            'Jewelry',
            'Woodwork',
            'Ceramics',
            'Textiles',
            'Illustration',
            'Home Decor',
        ])->map(fn(string $name) => Category::firstOrCreate(['name' => $name]));

        $admin = User::factory()->create([
            'username' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@makersmarkt.test',
            'role_id' => $adminRole->id,
            'is_verified' => true,
        ]);

        $makers = User::factory(8)->create([
            'role_id' => $makerRole->id,
            'is_verified' => true,
        ]);

        $buyers = User::factory(12)->create([
            'role_id' => $buyerRole->id,
            'is_verified' => true,
        ]);

        $allUsers = collect([$admin])->merge($makers)->merge($buyers);

        foreach ($allUsers as $user) {
            Profile::factory()->create(['user_id' => $user->id]);
            Credit::factory()->create([
                'user_id' => $user->id,
                'balance' => fake()->randomFloat(2, 20, 300),
            ]);
            Notification::factory(fake()->numberBetween(1, 3))->create([
                'user_id' => $user->id,
            ]);
        }

        $products = collect();

        foreach ($makers as $maker) {
            $makerProducts = Product::factory(fake()->numberBetween(2, 4))->create([
                'maker_id' => $maker->id,
                'category_id' => $categories->random()->id,
                'is_approved' => true,
            ]);

            $products = $products->merge($makerProducts);
        }

        $orders = collect();
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];

        for ($i = 0; $i < 25; $i++) {
            $buyer = $buyers->random();
            $product = $products->random();

            $order = Order::factory()->create([
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
                'status' => fake()->randomElement($statuses),
            ]);

            $orders->push($order);
        }

        foreach ($orders->where('status', 'completed')->take(15) as $order) {
            Review::factory()->create(['order_id' => $order->id]);

            CreditTransaction::factory()->create([
                'from_user_id' => $order->buyer_id,
                'to_user_id' => $order->product->maker_id,
                'order_id' => $order->id,
                'amount' => fake()->randomFloat(2, 10, 120),
            ]);
        }

        foreach ($products->random(min(8, $products->count())) as $product) {
            Report::factory()->create([
                'product_id' => $product->id,
                'reported_by' => $buyers->random()->id,
            ]);
        }
    }
}
