@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('partials.page-header', [
        'title' => $user->name,
        'subtitle' => 'Detalle del usuario',
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
        'actionUrl' => route('users.edit', $user),
        'actionLabel' => 'Editar usuario',
    ])

    <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</dt>
            <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $user->name }}</dd>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
            <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $user->email }}</dd>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rol</dt>
            <dd class="mt-2">
                @if ($user->isAdmin())
                    <span class="inline-flex rounded-full bg-slate-900 px-2.5 py-1 text-xs font-semibold text-white">Admin</span>
                @else
                    <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">Cliente</span>
                @endif
            </dd>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pedidos</dt>
            <dd class="mt-2 text-lg font-semibold tabular-nums text-slate-900">{{ $user->orders_count }}</dd>
        </div>
    </dl>
@endsection
