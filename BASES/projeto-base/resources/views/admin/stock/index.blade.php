@extends('layouts.app')
@section('title', 'Estoque')
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), 'Estoque' => null]" />
<div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h3 mb-1">Estoque</h1><p class="text-secondary mb-0">Consulte disponibilidade e registre ajustes.</p></div></div>
<div class="card"><div class="card-body">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Pesquisar produto"></div>
        <div class="col-md-3"><select class="form-select" name="availability"><option value="">Todas as situações</option><option value="available" @selected(request('availability') === 'available')>Disponíveis</option><option value="out" @selected(request('availability') === 'out')>Sem estoque</option></select></div>
        <div class="col-md-2"><input class="form-control" type="date" name="date_from" aria-label="Cadastrado a partir de" value="{{ request('date_from') }}"></div>
        <div class="col-md-2"><input class="form-control" type="date" name="date_to" aria-label="Cadastrado até" value="{{ request('date_to') }}"></div>
        <div class="col-auto"><button class="btn btn-outline-primary">Filtrar</button></div>
    </form>
    <x-table><thead><tr>
        @foreach(['name' => 'Produto', 'stock' => 'Estoque', 'price' => 'Preço', 'created_at' => 'Data de cadastro'] as $column => $label)
            <th><a class="table-sort-link" href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => request('sort') === $column && request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}">{{ $label }} <i class="bi bi-arrow-down-up ms-1 text-secondary opacity-50"></i></a></th>
        @endforeach
        <th>Categoria</th><th>SKU</th><th>Ajustar</th></tr></thead><tbody>
        @forelse($products as $product)
            <tr><td class="fw-semibold">{{ $product->name }}</td><td><span class="badge text-bg-{{ $product->stock ? 'success' : 'danger' }}">{{ $product->stock }}</span></td><td>{{ formatMoney($product->price) }}</td><td>{{ formatDate($product->created_at, 'd/m/Y H:i') }}</td><td>{{ $product->category?->name ?? '—' }}</td><td>{{ $product->sku }}</td><td>
                <form method="POST" action="{{ route('admin.stock.adjust', $product) }}" class="d-flex gap-2">@csrf
                    <select class="form-select form-select-sm" name="direction" required><option value="increase">Entrada</option><option value="decrease">Saída</option></select>
                    <input class="form-control form-control-sm" name="quantity" type="number" min="1" value="1" required style="max-width:90px">
                    <button class="btn btn-sm btn-outline-primary">Aplicar</button>
                </form>
            </td></tr>
        @empty<tr><td colspan="7" class="text-center text-secondary py-4">Nenhum produto encontrado.</td></tr>@endforelse
    </tbody></x-table>
    <x-pagination :paginator="$products" />
</div></div>
@endsection
