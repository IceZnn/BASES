@props(['items' => []])
<nav aria-label="breadcrumb"><ol class="breadcrumb small">@foreach($items as $label => $url)<li class="breadcrumb-item">@if($url)<a href="{{ $url }}">{{ $label }}</a>@else{{ $label }}@endif</li>@endforeach</ol></nav>
