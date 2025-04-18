<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory(10)->create()->each( function ( Order $order) {
            OrderItem::factory(random_int(1, 5))->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
