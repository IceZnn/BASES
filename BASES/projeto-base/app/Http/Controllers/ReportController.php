<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'totalUsers' => User::count(),
            'totalClients' => Client::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total'),
            'inventoryValue' => Product::sum(DB::raw('price * stock')),
            'topProducts' => Product::with('category')
                ->withSum('orders as units_sold', 'order_items.quantity')
                ->whereHas('orders')
                ->orderByDesc('units_sold')
                ->limit(10)
                ->get(),
            'ordersByStatus' => Order::query()->select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
        ]);
    }

    public function export()
    {
        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Pedido', 'Cliente', 'Status', 'Total', 'Data'], ';');

            Order::with('client')->latest()->chunk(200, function ($orders) use ($output): void {
                foreach ($orders as $order) {
                    fputcsv($output, [
                        $order->id,
                        $order->client->name,
                        $order->status,
                        number_format((float) $order->total, 2, ',', '.'),
                        $order->ordered_at->format('d/m/Y H:i'),
                    ], ';');
                }
            });

            fclose($output);
        }, 'relatorio-pedidos.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
