@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    @include('partials.page-header', [
        'title' => 'Mis pedidos',
        'subtitle' => 'Historial de tus compras',
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
                                <a href="{{ route('client.orders.show', $order) }}"
                                   class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No tienes pedidos registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Tus compras aparecerán aquí cuando realices un pedido.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
