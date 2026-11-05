@if($errors->any())
    <div class="mb-3">
        @if($errors->any())
            <div class="alert alert-danger" role="alert"><strong>Revise os campos:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
    </div>
@endif
