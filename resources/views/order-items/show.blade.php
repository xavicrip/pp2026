@extends('layouts.app')

@section('title', 'Item #'.$orderItem->id)

@section('content')
    @include('partials.page-header', [
        'title' => 'Item #' . $orderItem->id,
        'subtitle' => 'Detalle del item de orden',
        'backUrl' => route('order-items.index'),
        'backLabel' => 'Volver a items',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Item de orden</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">#{{ $orderItem->id }}</h1>
                <p class="mt-1 text-sm text-slate-500">Orden #{{ $orderItem->order_id }}</p>
            </div>
            <a href="{{ route('order-items.edit', $orderItem) }}"
               class="inline-flex shrink-0 items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Editar item
            </a>
        </div>

        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Producto</dt>
                <dd class="mt-2 text-base font-medium text-slate-900">
                    {{ $orderItem->product?->name ?? 'Producto eliminado' }}
                </dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Cantidad</dt>
                <dd class="mt-2 text-2xl font-bold tabular-nums text-slate-900">{{ $orderItem->quantity }}</dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Precio unitario</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-slate-900">
                    ${{ number_format($orderItem->unit_price, 2) }}
                </dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-slate-900">
                    ${{ number_format($orderItem->subtotal, 2) }}
                </dd>
            </div>
        </dl>
    </div>
@endsection
