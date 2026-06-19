@extends('layouts.app')

@section('title', 'Orden #'.$order->id)

@section('content')
    <h1>Orden #{{ $order->id }}</h1>
    <p>Usuario: {{ $order->user?->name }}</p>
    <p>Estado: {{ $order->status }}</p>
    <p>Total: ${{ $order->total }}</p>
    <p>Dirección: {{ $order->shipping_address }}</p>
    <h2>Items</h2>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product?->name }} x {{ $item->quantity }} = ${{ $item->subtotal }}</li>
        @endforeach
    </ul>
    <a href="{{ route('orders.edit', $order) }}">Editar</a>
    <a href="{{ route('orders.index') }}">Volver</a>
@endsection
