@extends('layouts.app')

@section('title', 'Nuevo item de orden')

@section('content')
    <h1>Nuevo item de orden</h1>
    <form action="{{ route('order-items.store') }}" method="POST">
        @csrf
        <label>Orden
            <select name="order_id" required>
                @foreach ($orders as $order)
                    <option value="{{ $order->id }}" @selected(old('order_id') == $order->id)>#{{ $order->id }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Producto
            <select name="product_id" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Cantidad <input type="number" name="quantity" value="{{ old('quantity', 1) }}" required></label><br>
        <label>Precio unitario <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" required></label><br>
        <label>Subtotal <input type="number" step="0.01" name="subtotal" value="{{ old('subtotal') }}" required></label><br>
        <button type="submit">Guardar</button>
    </form>
@endsection
