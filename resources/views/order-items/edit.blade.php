@extends('layouts.app')

@section('title', 'Editar item de orden')

@section('content')
    <h1>Editar item de orden</h1>
    <form action="{{ route('order-items.update', $orderItem) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Orden
            <select name="order_id" required>
                @foreach ($orders as $order)
                    <option value="{{ $order->id }}" @selected(old('order_id', $orderItem->order_id) == $order->id)>#{{ $order->id }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Producto
            <select name="product_id" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id', $orderItem->product_id) == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Cantidad <input type="number" name="quantity" value="{{ old('quantity', $orderItem->quantity) }}" required></label><br>
        <label>Precio unitario <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', $orderItem->unit_price) }}" required></label><br>
        <label>Subtotal <input type="number" step="0.01" name="subtotal" value="{{ old('subtotal', $orderItem->subtotal) }}" required></label><br>
        <button type="submit">Actualizar</button>
    </form>
@endsection
