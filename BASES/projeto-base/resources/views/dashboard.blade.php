@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<x-breadcrumb :items="['Início' => route('home'), 'Dashboard' => null]" />
<div class="mb-4"><h1 class="h3 mb-1">Dashboard</h1><p class="text-secondary mb-0">Resumo dos principais dados do sistema.</p></div>
<div class="row g-3 mb-4">
    @foreach([['Usuários', $users, 'people', 'primary'], ['Produtos', $products, 'box-seam', 'success'], ['Categorias', $categories, 'tags', 'info'], ['Clientes', $clients, 'person-lines-fill', 'warning'], ['Pedidos', $orders, 'receipt', 'info'], ['Em estoque', $in_stock, 'check2-circle', 'success'], ['Sem estoque', $out_of_stock, 'exclamation-circle', 'danger']] as [$label, $count, $icon, $color])
        <div class="col-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-secondary small">{{ $label }}</div><div class="h3 mb-0">{{ number_format($count) }}</div></div><span class="rounded-circle bg-{{ $color }}-subtle text-{{ $color }} p-3"><i class="bi bi-{{ $icon }} fs-5"></i></span></div></div></div>
    @endforeach
</div>
<div class="row g-3">
    <div class="col-lg-7"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Vendas nos últimos 6 meses</div><div class="card-body"><canvas id="salesChart" height="100"></canvas></div></div></div>
    <div class="col-lg-5"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Pedidos por status</div><div class="card-body"><canvas id="ordersChart" height="145"></canvas></div></div></div>
    <div class="col-lg-7"><div class="card h-100"><div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between"><strong>Pedidos recentes</strong><span class="text-secondary">Vendas no mês: {{ formatMoney($monthly_sales) }}</span></div><div class="card-body pt-0"><x-table><thead><tr><th>Pedido</th><th>Cliente</th><th>Status</th><th>Total</th><th>Data</th></tr></thead><tbody>@forelse($recent_orders as $order)<tr><td>#{{ $order->id }}</td><td>{{ $order->client->name }}</td><td><span class="badge text-bg-light">{{ ucfirst($order->status) }}</span></td><td>{{ formatMoney($order->total) }}</td><td>{{ formatDate($order->ordered_at) }}</td></tr>@empty<tr><td colspan="5" class="text-center text-secondary py-4">Ainda não há pedidos.</td></tr>@endforelse</tbody></x-table></div></div></div>
    <div class="col-lg-5"><div class="card h-100"><div class="card-header bg-white border-0 pt-4 px-4"><strong>Cadastros recentes</strong></div><div class="card-body pt-0">@forelse($recent_users as $user)<div class="d-flex justify-content-between align-items-center border-bottom py-3"><div class="d-flex align-items-center gap-3"><span class="rounded-circle bg-primary-subtle text-primary p-2"><i class="bi bi-person"></i></span><div><div class="fw-semibold">{{ $user->name }}</div><small class="text-secondary">{{ $user->email }}</small></div></div><small class="text-secondary">{{ formatDate($user->created_at) }}</small></div>@empty<p class="text-secondary">Nenhum usuário cadastrado.</p>@endforelse</div></div></div>
    <div class="col-12"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Produtos mais vendidos</div><div class="card-body"><x-table><thead><tr><th>Produto</th><th>Categoria</th><th>Unidades vendidas</th></tr></thead><tbody>@forelse($top_products as $product)<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '—' }}</td><td>{{ $product->units_sold ?? 0 }}</td></tr>@empty<tr><td colspan="3" class="text-center text-secondary py-4">Ainda não há vendas de produtos.</td></tr>@endforelse</tbody></x-table></div></div></div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: { labels: @json($sales_chart->pluck('label')), datasets: [{ label: 'Vendas (R$)', data: @json($sales_chart->pluck('total')), backgroundColor: '#3758f9', borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
    new Chart(document.getElementById('ordersChart'), {
        type: 'doughnut',
        data: { labels: @json($orders_by_status->pluck('status')), datasets: [{ data: @json($orders_by_status->pluck('total')), backgroundColor: ['#3758f9', '#26a269', '#f0ad4e', '#dc3545'] }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush
