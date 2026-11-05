@props(['name', 'label', 'options' => [], 'value' => null, 'placeholder' => 'Selecione'])
@php($controlId = $attributes->get('id', $name))
<div>
    <label class="form-label small" for="{{ $controlId }}">{{ $label }}</label>
    <select id="{{ $controlId }}" name="{{ $name }}" {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)]) }}>
        @if($placeholder)<option value="">{{ $placeholder }}</option>@endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @selected((string) old($name, $value) === (string) $key)>{{ $option }}</option>
        @endforeach
    </select>
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
