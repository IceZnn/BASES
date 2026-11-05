<div {{ $attributes->class(['card']) }}>
    @isset($title)<div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">{{ $title }}</div>@endisset
    <div class="card-body p-4">{{ $slot }}</div>
</div>
