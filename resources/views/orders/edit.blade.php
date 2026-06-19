@extends('layouts.app')

@section('title', 'Editar orden')

@section('content')
    <h1>Editar orden</h1>
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Usuario
            <select name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $order->user_id) == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Estado <input type="text" name="status" value="{{ old('status', $order->status) }}" required></label><br>
        <label>Subtotal <input type="number" step="0.01" name="subtotal" value="{{ old('subtotal', $order->subtotal) }}" required></label><br>
        <label>Impuesto <input type="number" step="0.01" name="tax" value="{{ old('tax', $order->tax) }}" required></label><br>
        <label>Total <input type="number" step="0.01" name="total" value="{{ old('total', $order->total) }}" required></label><br>
        <label>Dirección <input type="text" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address) }}"></label><br>
        <button type="submit">Actualizar</button>
    </form>
@endsection
