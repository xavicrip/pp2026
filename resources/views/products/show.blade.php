@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @include('partials.page-header', [
        'title' => $product->name,
        'subtitle' => 'Detalle del producto',
        'backUrl' => route('products.index'),
        'backLabel' => 'Volver a productos',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Producto</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $product->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">Slug: {{ $product->slug }}</p>
            </div>
            <a href="{{ route('products.edit', $product) }}"
               class="inline-flex shrink-0 items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Editar producto
            </a>
        </div>

        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Precio</dt>
                <dd class="mt-2 text-2xl font-bold tabular-nums text-slate-900">
                    ${{ number_format($product->price, 2) }}
                </dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</dt>
                <dd class="mt-2 text-base font-medium text-slate-900">{{ $product->category?->name ?? '—' }}</dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                <dd class="mt-2">
                    @if ($product->is_active)
                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                            Activo
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">
                            Inactivo
                        </span>
                    @endif
                </dd>
            </div>
        </dl>

        @if ($product->description)
            <div class="border-t border-slate-200 px-6 py-6">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripción</h2>
                <p class="mt-2 leading-relaxed text-slate-700">{{ $product->description }}</p>
            </div>
        @endif
    </div>
@endsection
