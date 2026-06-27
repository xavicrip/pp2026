@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    @include('partials.page-header', [
        'title' => 'Productos',
        'subtitle' => 'Catálogo de productos del ecommerce',
        'actionUrl' => route('products.create'),
        'actionLabel' => 'Nuevo producto',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Precio</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-5 py-4 tabular-nums text-slate-600">${{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('products.show', $product),
                                    'editUrl' => route('products.edit', $product),
                                    'destroyUrl' => route('products.destroy', $product),
                                    'confirmMessage' => '¿Eliminar este producto?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay productos registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primero desde el botón “Nuevo producto”.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
