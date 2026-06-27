@extends('layouts.app')

@section('title', 'Pedido #'.$order->id)

@section('content')
    @include('partials.page-header', [
        'title' => 'Pedido #' . $order->id,
        'subtitle' => 'Detalle de tu pedido',
        'backUrl' => route('client.orders.index'),
        'backLabel' => 'Volver a mis pedidos',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pedido</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">#{{ $order->id }}</h1>
            <p class="mt-1 text-sm text-slate-500">Realizado el {{ $order->created_at?->format('d/m/Y H:i') }}</p>
        </div>

        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                <dd class="mt-2">
                    @php
                        $statusClasses = match ($order->status) {
                            'completed', 'delivered' => 'bg-emerald-100 text-emerald-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'processing', 'shipped' => 'bg-blue-100 text-blue-800',
                            default => 'bg-amber-100 text-amber-800',
                        };
                    @endphp
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                        {{ $order->status }}
                    </span>
                </dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-slate-900">${{ number_format($order->subtotal, 2) }}</dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Impuesto</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-slate-900">${{ number_format($order->tax, 2) }}</dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-slate-900">${{ number_format($order->total, 2) }}</dd>
            </div>
        </dl>

        @if ($order->shipping_address)
            <div class="border-t border-slate-200 px-6 py-6">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dirección de envío</h2>
                <p class="mt-2 text-slate-700">{{ $order->shipping_address }}</p>
            </div>
        @endif

        <div class="border-t border-slate-200 px-6 py-6">
            <h2 class="mb-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Items del pedido</h2>

            @if ($order->items->isNotEmpty())
                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Cantidad</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900">
                                        {{ $item->product?->name ?? 'Producto eliminado' }}
                                    </td>
                                    <td class="px-4 py-3 tabular-nums text-slate-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right tabular-nums text-slate-600">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500">Este pedido no tiene items registrados.</p>
            @endif
        </div>
    </div>
@endsection
