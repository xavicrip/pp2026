@extends('layouts.app')

@section('title', 'Editar item de orden')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar item de orden',
        'subtitle' => 'Item #' . $orderItem->id,
        'backUrl' => route('order-items.index'),
        'backLabel' => 'Volver a items',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del item</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('order-items.update', $orderItem) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="order_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Orden <span class="text-red-500">*</span>
                </label>
                <select id="order_id" name="order_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" @selected(old('order_id', $orderItem->order_id) == $order->id)>
                            #{{ $order->id }}
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="product_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Producto <span class="text-red-500">*</span>
                </label>
                <select id="product_id" name="product_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected(old('product_id', $orderItem->product_id) == $product->id)>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @include('partials.form-field', [
                'label' => 'Cantidad',
                'name' => 'quantity',
                'type' => 'number',
                'value' => old('quantity', $orderItem->quantity),
                'required' => true,
                'min' => '1',
            ])

            @include('partials.form-field', [
                'label' => 'Precio unitario',
                'name' => 'unit_price',
                'type' => 'number',
                'value' => old('unit_price', $orderItem->unit_price),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            @include('partials.form-field', [
                'label' => 'Subtotal',
                'name' => 'subtotal',
                'type' => 'number',
                'value' => old('subtotal', $orderItem->subtotal),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('order-items.index'),
                'submitLabel' => 'Actualizar item',
            ])
        </form>
    </div>
@endsection
