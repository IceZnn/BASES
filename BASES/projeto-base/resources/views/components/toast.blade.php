@if(session('success') || session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090">
        @foreach(['success' => 'success', 'error' => 'danger'] as $key => $variant)
            @if(session($key))
                <div class="toast align-items-center text-bg-{{ $variant }} border-0" role="status" aria-live="polite" aria-atomic="true" data-auto-toast>
                    <div class="d-flex"><div class="toast-body">{{ session($key) }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button></div>
                </div>
            @endif
        @endforeach
    </div>
@endif
