<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardService
{
    public function summary(): array
    {
        return [
            'users' => User::count(),
            'products' => Product::count(),
            'categories' => Category::count(),
            'clients' => Client::count(),
            'orders' => Order::count(),
            'in_stock' => Product::where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'recent_orders' => Order::with('client')->latest()->limit(5)->get(),
            'recent_users' => User::latest()->limit(5)->get(),
            'top_products' => Product::query()
                ->with('category')
                ->withSum('orders as units_sold', 'order_items.quantity')
                ->whereHas('orders')
                ->orderByDesc('units_sold')
                ->limit(5)
                ->get(),
            'monthly_sales' => Order::query()
                ->whereBetween('ordered_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('total'),
            'sales_chart' => collect(range(5, 0))->map(function (int $offset): array {
                $month = now()->subMonths($offset);

                return [
                    'label' => $month->locale('pt_BR')->translatedFormat('M'),
                    'total' => Order::query()
                        ->whereBetween('ordered_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                        ->sum('total'),
                ];
            }),
            'orders_by_status' => Order::query()->selectRaw('status, count(*) as total')->groupBy('status')->get(),
        ];
    }
}
