<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'availability' => ['nullable', 'in:out,available'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'sort' => ['nullable', 'in:name,stock,price,created_at'],
            'direction' => ['nullable', 'in:asc,desc'],
        ]);
        $products = Product::query()
            ->with(['category', 'supplier'])
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search')->trim().'%'))
            ->when($request->input('availability') === 'out', fn ($query) => $query->where('stock', 0))
            ->when($request->input('availability') === 'available', fn ($query) => $query->where('stock', '>', 0))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('products.created_at', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('products.created_at', '<=', $request->input('date_to')))
            ->orderBy($request->input('sort', 'stock'), $request->input('direction', 'asc'))
            ->paginate(10)
            ->withQueryString();

        return view('admin.stock.index', compact('products'));
    }

    public function adjust(Request $request, Product $product)
    {
        $data = $request->validate([
            'direction' => ['required', 'in:increase,decrease'],
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'direction.required' => 'Selecione o tipo de ajuste.',
            'quantity.required' => 'Informe a quantidade.',
            'quantity.min' => 'A quantidade deve ser maior que zero.',
        ]);

        $updated = DB::transaction(function () use ($data, $product): bool {
            $lockedProduct = Product::query()->lockForUpdate()->findOrFail($product->id);
            if ($data['direction'] === 'decrease' && $lockedProduct->stock < $data['quantity']) {
                return false;
            }

            $newStock = $data['direction'] === 'increase'
                ? $lockedProduct->stock + $data['quantity']
                : $lockedProduct->stock - $data['quantity'];
            $lockedProduct->update(['stock' => $newStock]);

            return true;
        });

        if (! $updated) {
            return back()->withErrors(['quantity' => 'O ajuste não pode deixar o estoque abaixo de zero.']);
        }

        return back()->with('success', 'Estoque ajustado com sucesso.');
    }
}
