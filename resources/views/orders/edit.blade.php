@extends('layouts.app')

@section('title', 'Editar orden')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar orden',
        'subtitle' => 'Orden #' . $order->id,
        'backUrl' => route('orders.index'),
        'backLabel' => 'Volver a órdenes',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos de la orden</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('orders.update', $order) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="user_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Usuario <span class="text-red-500">*</span>
                </label>
                <select id="user_id" name="user_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $order->user_id) == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @include('partials.form-field', [
                'label' => 'Estado',
                'name' => 'status',
                'value' => old('status', $order->status),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Subtotal',
                'name' => 'subtotal',
                'type' => 'number',
                'value' => old('subtotal', $order->subtotal),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            @include('partials.form-field', [
                'label' => 'Impuesto',
                'name' => 'tax',
                'type' => 'number',
                'value' => old('tax', $order->tax),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            @include('partials.form-field', [
                'label' => 'Total',
                'name' => 'total',
                'type' => 'number',
                'value' => old('total', $order->total),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            @include('partials.form-field', [
                'label' => 'Dirección de envío',
                'name' => 'shipping_address',
                'value' => old('shipping_address', $order->shipping_address),
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('orders.index'),
                'submitLabel' => 'Actualizar orden',
            ])
        </form>
    </div>
@endsection
