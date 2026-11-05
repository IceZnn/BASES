@extends('layouts.app')
@section('title', 'Relatórios')
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), 'Relatórios' => null]" />
<div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h3 mb-1">Relatórios</h1><p class="text-secondary mb-0">Indicadores operacionais da aplicação.</p></div><a href="{{ route('admin.reports.export') }}" class="btn btn-outline-primary"><i class="bi bi-download me-1"></i>Exportar pedidos CSV</a></div>
<div class="row g-3 mb-4">
    @foreach([['Usuários', $totalUsers], ['Categorias', $totalCategories], ['Clientes', $totalClients], ['Pedidos', $totalOrders], ['Faturamento concluído', formatMoney($revenue)], ['Valor em estoque', formatMoney($inventoryValue)]] as [$label, $value])
        <div class="col-sm-6 col-xl"><div class="card h-100"><div class="card-body"><div class="text-secondary small">{{ $label }}</div><div class="h4 mt-2 mb-0">{{ $value }}</div></div></div></div>
    @endforeach
</div>
<div class="row g-3">
    <div class="col-lg-5"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Pedidos por status</div><div class="card-body">@forelse($ordersByStatus as $status)<div class="d-flex justify-content-between border-bottom py-2"><span>{{ ucfirst($status->status) }}</span><strong>{{ $status->total }}</strong></div>@empty<p class="text-secondary mb-0">Sem pedidos.</p>@endforelse</div></div></div>
    <div class="col-lg-7"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Produtos mais vendidos</div><div class="card-body"><x-table><thead><tr><th>Produto</th><th>Categoria</th><th>Unidades vendidas</th></tr></thead><tbody>@forelse($topProducts as $product)<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '—' }}</td><td>{{ $product->units_sold ?? 0 }}</td></tr>@empty<tr><td colspan="3" class="text-center text-secondary">Sem dados.</td></tr>@endforelse</tbody></x-table></div></div></div>
</div>
@endsection
