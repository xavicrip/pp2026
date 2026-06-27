@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nuevo producto',
        'subtitle' => 'Completa los datos para publicar en el catálogo',
        'backUrl' => route('products.index'),
        'backLabel' => 'Volver a productos',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del producto</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="p-6">
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

            @include('partials.form-field', [
                'label' => 'Precio',
                'name' => 'price',
                'type' => 'number',
                'value' => old('price'),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            <div class="mb-5">
                <label for="category_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       @checked(old('is_active', true))
                       class="size-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                <label for="is_active" class="text-sm font-medium text-slate-700">Producto activo en el catálogo</label>
            </div>

            @include('partials.form-actions', [
                'cancelUrl' => route('products.index'),
                'submitLabel' => 'Guardar producto',
            ])
        </form>
    </div>
@endsection
