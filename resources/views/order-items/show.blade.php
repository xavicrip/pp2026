@extends('layouts.app')

@section('title', 'Item #'.$orderItem->id)

@section('content')
    <h1>Item #{{ $orderItem->id }}</h1>
    <p>Orden: #{{ $orderItem->order_id }}</p>
    <p>Producto: {{ $orderItem->product?->name }}</p>
    <p>Cantidad: {{ $orderItem->quantity }}</p>
    <p>Subtotal: ${{ $orderItem->subtotal }}</p>
    <a href="{{ route('order-items.edit', $orderItem) }}">Editar</a>
    <a href="{{ route('order-items.index') }}">Volver</a>
@endsection
