<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'basket' => 'required|array|min:1',
            'basket.*.name' => 'required|string|max:255',
            'basket.*.type' => 'required|in:unit,subscription',
            'basket.*.price' => 'required|numeric|min:0.01',
        ]);
        
        // Create the order
        $order = Order::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
        ]);

        // Create the order items and store them in the order_items table
        foreach ($validated['basket'] as $item) {
            $orderItem = new OrderItem([
                'name' => $item['name'],
                'type' => $item['type'],
                'price' => $item['price'],
            ]);
            $order->orderItems()->save($orderItem);

            if ($item['type'] === 'subscription') {
                Http::async()->post('https://very-slow-api.com/orders', [
                    'ProductName' => $item['name'],
                    'Price' => $item['price'],
                    'Timestamp' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order,
        ], 201);
    }
}
