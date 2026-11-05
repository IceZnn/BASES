<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService
{
    public function syncProducts(Order $order, array $productIds): void
    {
        $products = Product::query()->whereIn('id', $productIds)->get();
        $pivot = $products->mapWithKeys(fn (Product $product) => [
            $product->id => ['quantity' => 1, 'unit_price' => $product->price],
        ])->all();

        $order->products()->sync($pivot);
        $order->update(['total' => $products->sum('price')]);
    }
}
