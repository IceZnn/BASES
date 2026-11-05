@extends('layouts.app')
@section('title', ($record ? 'Editar ' : 'Novo ').strtolower($title))
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), $titlePlural => route('admin.'.$resource.'.index'), ($record ? 'Editar' : 'Novo cadastro') => null]" />
<div class="mb-4"><h1 class="h3 mb-1">{{ $record ? 'Editar' : 'Cadastrar' }} {{ strtolower($title) }}</h1><p class="text-secondary mb-0">Preencha os campos abaixo e salve as alterações.</p></div>
<div class="card"><div class="card-body p-4">
    <form method="POST" enctype="multipart/form-data" action="{{ $record ? route('admin.'.$resource.'.update', $record->id) : route('admin.'.$resource.'.store') }}">
        @csrf
        @if($record) @method('PUT') @endif
        <div class="row">
        @foreach($fields as $field)
            @continue($field['readOnly'] ?? false)
            @php
                $name = $field['name'];
                $value = old($name, $record ? data_get($record, $field['display'] ?? $name) : '');
                if (($field['multiple'] ?? false) && $record && !old($name)) {
                    $value = $record->products->modelKeys();
                }
                $controlId = str_replace(['[', ']'], '', $name);
            @endphp
            <div class="col-md-{{ in_array($field['type'], ['textarea', 'file'], true) ? '12' : '6' }} mb-3">
                <label for="{{ $controlId }}" class="form-label">{{ $field['label'] }}</label>
                @if($field['type'] === 'textarea')
                    <textarea id="{{ $controlId }}" name="{{ $name }}" rows="3" @required(($field['required'] ?? str_contains($field['rules'] ?? '', 'required')) && ! ($field['type'] === 'password' && $record)) class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
                @elseif($field['type'] === 'select')
                    <select id="{{ $controlId }}" name="{{ $name }}{{ ($field['multiple'] ?? false) ? '[]' : '' }}" class="form-select @error($name) is-invalid @enderror" @required(($field['required'] ?? str_contains($field['rules'] ?? '', 'required')) && ! ($field['type'] === 'password' && $record)) @if($field['multiple'] ?? false) multiple size="5" @endif>
                        @unless($field['multiple'] ?? false)<option value="">Selecione</option>@endunless
                        @foreach($options[$name] ?? [] as $key => $option)
                            @if($field['multiple'] ?? false)
                                <option value="{{ $key }}" @selected(in_array((string) $key, array_map('strval', (array) $value), true))>{{ $option }}</option>
                            @else
                                <option value="{{ $key }}" @selected((string) $value === (string) $key)>{{ $option }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($field['multiple'] ?? false)<div class="form-text">Use Ctrl (Windows) ou Command (Mac) para selecionar mais de um produto.</div>@endif
                @elseif($field['type'] === 'file')
                    <input id="{{ $controlId }}" type="file" name="{{ $name }}" @required(($field['required'] ?? str_contains($field['rules'] ?? '', 'required')) && ! $record) class="form-control @error($name) is-invalid @enderror" accept="image/*">
                    @if($record && $record->{$name})<img class="mt-2 rounded" src="{{ Storage::disk('public')->url($record->{$name}) }}" alt="Imagem atual" style="max-width:140px;max-height:100px">@endif
                @else
                    <input id="{{ $controlId }}" type="{{ $field['type'] }}" name="{{ $name }}" value="{{ $field['type'] === 'password' ? '' : $value }}" @if(isset($field['step'])) step="{{ $field['step'] }}" @endif @required(($field['required'] ?? str_contains($field['rules'] ?? '', 'required')) && ! ($field['type'] === 'password' && $record)) class="form-control @error($name) is-invalid @enderror">
                    @if($field['type'] === 'password' && $record)<div class="form-text">Deixe em branco para manter a senha atual.</div>@endif
                @endif
                @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        @endforeach
        </div>
        <div class="d-flex gap-2 mt-2"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button><a class="btn btn-light" href="{{ route('admin.'.$resource.'.index') }}">Cancelar</a></div>
    </form>
</div></div>
@endsection
