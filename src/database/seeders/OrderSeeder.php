<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $tables = Table::all();
        $products = Product::all();

        if ($tables->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Create 100 random orders over the last 7 days
        for ($i = 0; $i < 100; $i++) {
            $date = Carbon::now()->subDays(rand(0, 6));
            
            $order = Order::create([
                'table_id' => $tables->random()->id,
                'status' => 'completed',
                'total_amount' => 0,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $totalAmount = 0;
            $itemsCount = rand(1, 5);

            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $totalAmount += $price;
            }

            $order->update(['total_amount' => $totalAmount]);
        }
    }
}
