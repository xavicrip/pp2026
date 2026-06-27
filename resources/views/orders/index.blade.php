@extends('layouts.app')

@section('title', 'Órdenes')

@section('content')
    @include('partials.page-header', [
        'title' => 'Órdenes',
        'subtitle' => 'Gestión de pedidos del ecommerce',
        'actionUrl' => route('orders.create'),
        'actionLabel' => 'Nueva orden',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">ID</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Total</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Fecha</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">#{{ $order->id }}</td>
                            <td class="px-5 py-4">
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
                            </td>
                            <td class="px-5 py-4 tabular-nums text-slate-600">${{ number_format($order->total, 2) }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('orders.show', $order),
                                    'editUrl' => route('orders.edit', $order),
                                    'destroyUrl' => route('orders.destroy', $order),
                                    'confirmMessage' => '¿Eliminar esta orden?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay órdenes registradas</p>
                                <p class="mt-1 text-sm text-slate-500">Crea la primera desde el botón “Nueva orden”.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
