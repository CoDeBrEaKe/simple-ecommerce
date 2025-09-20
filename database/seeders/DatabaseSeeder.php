<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use database\factories\ProductFactory;
use database\factories\OrderFactory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'), 
            'is_admin' => 1, 
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('123456'), 
            'is_admin' => 0, 
        ]);


        $products = Product::factory(20)->create();

       
        Order::factory(10)->create()->each(function ($order) use ($products) {
           
            $selectedProducts = $products->random(rand(1, 5));

            $total = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price * $quantity;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price;
            }

            // تحديث سعر الأوردر
            $order->update(['total_price' => $total]);
        });
    }
}
