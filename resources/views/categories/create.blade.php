@extends('layouts.app')

@section('title', 'Nueva categoría')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nueva categoría',
        'subtitle' => 'Define una categoría para agrupar productos',
        'backUrl' => route('categories.index'),
        'backLabel' => 'Volver a categorías',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos de la categoría</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="p-6">
            @csrf

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Slug',
                'name' => 'slug',
                'value' => old('slug'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Descripción',
                'name' => 'description',
                'type' => 'textarea',
                'value' => old('description'),
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('categories.index'),
                'submitLabel' => 'Guardar categoría',
            ])
        </form>
    </div>
@endsection
