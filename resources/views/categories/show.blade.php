@extends('layouts.app')

@section('title', $category->name)

@section('content')
    @include('partials.page-header', [
        'title' => $category->name,
        'subtitle' => 'Detalle de la categoría',
        'backUrl' => route('categories.index'),
        'backLabel' => 'Volver a categorías',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $category->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">Slug: {{ $category->slug }}</p>
            </div>
            <a href="{{ route('categories.edit', $category) }}"
               class="inline-flex shrink-0 items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Editar categoría
            </a>
        </div>

        @if ($category->description)
            <div class="px-6 py-6">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripción</h2>
                <p class="mt-2 leading-relaxed text-slate-700">{{ $category->description }}</p>
            </div>
        @endif
    </div>
@endsection
