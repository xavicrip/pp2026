@extends('layouts.app')

@section('title', 'Items de orden')

@section('content')
    @include('partials.page-header', [
        'title' => 'Items de orden',
        'subtitle' => 'Líneas de detalle de cada pedido',
        'actionUrl' => route('order-items.create'),
        'actionLabel' => 'Nuevo item',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Orden</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Producto</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Cantidad</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orderItems as $orderItem)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">#{{ $orderItem->order_id }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $orderItem->product?->name ?? 'Producto eliminado' }}</td>
                            <td class="px-5 py-4 tabular-nums text-slate-600">{{ $orderItem->quantity }}</td>
                            <td class="px-5 py-4 tabular-nums text-slate-600">${{ number_format($orderItem->subtotal, 2) }}</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('order-items.show', $orderItem),
                                    'editUrl' => route('order-items.edit', $orderItem),
                                    'destroyUrl' => route('order-items.destroy', $orderItem),
                                    'confirmMessage' => '¿Eliminar este item?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay items registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primero desde el botón “Nuevo item”.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
