@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    @include('partials.page-header', [
        'title' => 'Categorías',
        'subtitle' => 'Agrupa productos por categoría',
        'actionUrl' => route('categories.create'),
        'actionLabel' => 'Nueva categoría',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Slug</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $category->name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $category->slug }}</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('categories.show', $category),
                                    'editUrl' => route('categories.edit', $category),
                                    'destroyUrl' => route('categories.destroy', $category),
                                    'confirmMessage' => '¿Eliminar esta categoría?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay categorías registradas</p>
                                <p class="mt-1 text-sm text-slate-500">Crea la primera desde el botón “Nueva categoría”.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
