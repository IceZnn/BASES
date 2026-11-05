@extends('layouts.app')
@section('title', 'Notificações')
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), 'Notificações' => null]" />
<h1 class="h3 mb-4">Notificações</h1>
<div class="card"><div class="list-group list-group-flush">
    @forelse($notifications as $notification)
        <div class="list-group-item p-4 d-flex justify-content-between gap-3 {{ $notification->read_at ? '' : 'bg-primary-subtle' }}">
            <div><div class="fw-semibold">{{ data_get($notification->data, 'title', 'Notificação') }}</div><p class="mb-1">{{ data_get($notification->data, 'message', 'Você recebeu uma nova notificação.') }}</p><small class="text-secondary">{{ formatDate($notification->created_at, 'd/m/Y H:i') }}</small></div>
            <div class="d-flex align-items-center gap-2">
                @unless($notification->read_at)<form method="POST" action="{{ route('notifications.read', $notification->id) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-primary">Marcar como lida</button></form>@endunless
                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" onsubmit="return confirm('Excluir esta notificação?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </div>
        </div>
    @empty<div class="p-5 text-center text-secondary">Você não tem notificações.</div>@endforelse
</div><div class="p-3">{{ $notifications->links() }}</div></div>
@endsection
