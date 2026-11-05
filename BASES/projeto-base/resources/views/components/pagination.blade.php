@props(['paginator'])
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
    <small class="text-secondary">Exibindo {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} de {{ $paginator->total() }} registros</small>
    {{ $paginator->links() }}
</div>
