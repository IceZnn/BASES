@extends('layouts.app')
@section('title', 'Detalhes · '.$title)
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), $titlePlural => route('admin.'.$resource.'.index'), 'Detalhes' => null]" />
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h3 mb-1">Detalhes do {{ strtolower($title) }}</h1><p class="text-secondary mb-0">{{ $title }} #{{ $record->id }}</p></div>
    <a class="btn btn-primary" href="{{ route('admin.'.$resource.'.edit', $record->id) }}"><i class="bi bi-pencil me-1"></i>Editar</a>
</div>
<div class="card"><dl class="row card-body mb-0">
    @foreach($fields as $field)
        @continue(in_array($field['name'], ['password', 'password_confirmation', 'image', 'photo', 'products'], true))
        @php($value = data_get($record, $field['display'] ?? $field['name']))
        <dt class="col-sm-3 text-secondary fw-normal">{{ $field['label'] }}</dt>
        <dd class="col-sm-9">
            @if(in_array($field['name'], ['price', 'total', 'orders_sum_total'], true))
                {{ formatMoney($value) }}
            @elseif(in_array($field['name'], ['status', 'role', 'is_active'], true))
                {{ $options[$field['name']][$value] ?? ucfirst((string) $value) }}
            @else
                {{ $value ?: '—' }}
            @endif
        </dd>
    @endforeach
    @foreach(['created_at' => 'Criado em', 'updated_at' => 'Atualizado em'] as $column => $label)
        @if($record->getAttribute($column))
            <dt class="col-sm-3 text-secondary fw-normal">{{ $label }}</dt>
            <dd class="col-sm-9">{{ formatDate($record->getAttribute($column), 'd/m/Y H:i') }}</dd>
        @endif
    @endforeach
    @if($record->getAttribute('image') || $record->getAttribute('photo'))
        <dt class="col-sm-3 text-secondary fw-normal">Imagem</dt>
        <dd class="col-sm-9"><img src="{{ imageUrl($record->getAttribute('image') ?: $record->getAttribute('photo')) }}" alt="Imagem de {{ strtolower($title) }}" class="img-thumbnail" style="max-width:240px;max-height:200px"></dd>
    @endif
    @if($record->relationLoaded('products') && $record->products->isNotEmpty())
        <dt class="col-sm-3 text-secondary fw-normal">Produtos do pedido</dt>
        <dd class="col-sm-9">
            <x-table>
                <thead><tr><th>Produto</th><th>Quantidade</th><th>Preço unitário</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($record->products as $product)
                        <tr><td>{{ $product->name }}</td><td>{{ $product->pivot->quantity }}</td><td>{{ formatMoney($product->pivot->unit_price) }}</td><td>{{ formatMoney($product->pivot->quantity * $product->pivot->unit_price) }}</td></tr>
                    @endforeach
                </tbody>
            </x-table>
        </dd>
    @endif
</dl></div>
@if($record->relationLoaded('orders') && $record->orders->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Pedidos do cliente</div>
        <div class="card-body pt-0">
            <x-table>
                <thead><tr><th>Pedido</th><th>Status</th><th>Total</th><th>Data</th><th></th></tr></thead>
                <tbody>
                    @foreach($record->orders as $order)
                        <tr><td>#{{ $order->id }}</td><td>{{ ucfirst($order->status) }}</td><td>{{ formatMoney($order->total) }}</td><td>{{ formatDate($order->ordered_at, 'd/m/Y H:i') }}</td><td class="text-end"><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light" aria-label="Ver pedido"><i class="bi bi-eye"></i></a></td></tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
    </div>
@endif
<a href="{{ route('admin.'.$resource.'.index') }}" class="btn btn-light mt-3"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
@endsection
