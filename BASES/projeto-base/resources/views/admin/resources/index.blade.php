@extends('layouts.app')
@section('title', $titlePlural)
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), $titlePlural => null]" />
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">{{ $titlePlural }}</h1><p class="text-secondary mb-0">Pesquise, filtre e gerencie os registros.</p></div>
    <a class="btn btn-primary" href="{{ route('admin.'.$resource.'.create') }}"><i class="bi bi-plus-lg me-1"></i>Novo {{ strtolower($title) }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.'.$resource.'.index') }}" class="row g-3 align-items-end mb-4">
            <div class="col-12 col-lg-4">
                <label class="form-label small" for="search">Pesquisa</label>
                <input id="search" class="form-control" name="search" value="{{ request('search') }}" placeholder="Pesquisar {{ strtolower($titlePlural) }}...">
            </div>
            @foreach($filterColumns as $column => $label)
                <div class="col-6 col-lg-2">
                    <x-select :name="$column" :label="$label" :options="$options[$column] ?? []" :value="request($column)" placeholder="Todos" />
                </div>
            @endforeach
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="date_from">{{ $dateColumnLabel }} a partir de</label>
                <input id="date_from" class="form-control" type="date" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-6 col-lg-2">
                <label class="form-label small" for="date_to">{{ $dateColumnLabel }} até</label>
                <input id="date_to" class="form-control" type="date" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-6 col-lg-auto">
                <label class="form-label small" for="per_page">Por página</label>
                <select id="per_page" class="form-select" name="per_page">
                    @foreach([10, 25, 50, 100] as $pageSize)<option value="{{ $pageSize }}" @selected((int) request('per_page', 10) === $pageSize)>{{ $pageSize }}</option>@endforeach
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i>Filtrar</button>
                <a class="btn btn-light" href="{{ route('admin.'.$resource.'.index') }}">Limpar</a>
            </div>
        </form>
        <x-table>
            <thead>
                <tr>
                    @foreach($fields as $field)
                        @if(($field['list'] ?? true) && !in_array($field['name'], ['password', 'password_confirmation', 'description', 'photo', 'image', 'products', 'notes'], true))
                            <th>
                                @if(in_array($field['name'], $sortableColumns, true))
                                    @php($nextDirection = $sort === $field['name'] && $direction === 'asc' ? 'desc' : 'asc')
                                    <a class="table-sort-link" href="{{ request()->fullUrlWithQuery(['sort' => $field['name'], 'direction' => $nextDirection, 'page' => 1]) }}">
                                        {{ $field['label'] }}
                                        @if($sort === $field['name'])<i class="bi bi-arrow-{{ $direction === 'asc' ? 'up' : 'down' }} ms-1"></i>@else<i class="bi bi-arrow-down-up ms-1 text-secondary opacity-50"></i>@endif
                                    </a>
                                @else
                                    {{ $field['label'] }}
                                @endif
                            </th>
                        @endif
                    @endforeach
                    <th><a class="table-sort-link" href="{{ request()->fullUrlWithQuery(['sort' => $dateColumn, 'direction' => $sort === $dateColumn && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}">{{ $dateColumnLabel }} <i class="bi bi-arrow-down-up ms-1 text-secondary opacity-50"></i></a></th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($records as $record)
                <tr>
                    @foreach($fields as $field)
                        @if(($field['list'] ?? true) && !in_array($field['name'], ['password', 'password_confirmation', 'description', 'photo', 'image', 'products', 'notes'], true))
                            @php($value = data_get($record, $field['display'] ?? $field['name']))
                            <td>
                                @if(in_array($field['name'], ['status', 'role', 'is_active'], true))
                                    <span class="badge rounded-pill text-bg-{{ in_array($value, ['active', '1', 1, true, 'completed'], true) ? 'success' : (in_array($value, ['pending', 'processing'], true) ? 'warning' : 'secondary') }}">{{ $options[$field['name']][$value] ?? ($value === 'active' ? 'Ativo' : ($value === 'inactive' ? 'Inativo' : ucfirst((string) $value))) }}</span>
                                @elseif(in_array($field['name'], ['price', 'total', 'orders_sum_total'], true))
                                    {{ formatMoney($value) }}
                                @elseif(in_array($field['type'], ['computed'], true))
                                    {{ $value ?? '—' }}
                                @else
                                    {{ $value ?: '—' }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    <td class="text-nowrap">{{ formatDate(data_get($record, $dateColumn), 'd/m/Y H:i') }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-light" href="{{ route('admin.'.$resource.'.show', $record->id) }}" title="Visualizar" aria-label="Visualizar"><i class="bi bi-eye"></i></a>
                        <a class="btn btn-sm btn-light" href="{{ route('admin.'.$resource.'.edit', $record->id) }}" title="Editar" aria-label="Editar"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-outline-danger" type="button" data-confirm-delete="{{ route('admin.'.$resource.'.destroy', $record->id) }}" data-record-label="{{ $title }} #{{ $record->id }}" data-bs-toggle="modal" data-bs-target="#delete-confirmation" title="Excluir" aria-label="Excluir"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($fields) + 2 }}" class="text-center text-secondary py-5"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Nenhum registro encontrado.</td></tr>
            @endforelse
            </tbody>
        </x-table>
        <x-pagination :paginator="$records" />
    </div>
</div>
<x-modal id="delete-confirmation" title="Confirmar exclusão">
    <p>Deseja excluir <strong data-delete-record-label>este registro</strong>? Esta ação não pode ser desfeita.</p>
    <form method="POST" data-delete-confirmation-form>
        @csrf @method('DELETE')
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i>Excluir</button>
        </div>
    </form>
</x-modal>
@endsection
