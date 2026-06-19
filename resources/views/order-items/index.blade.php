@extends('layouts.app')

@section('title', 'Items de orden')

@section('content')
    <h1>Items de orden</h1>
    <a href="{{ route('order-items.create') }}">Nuevo item</a>
    <ul>
        @foreach ($orderItems as $orderItem)
            <li>
                Orden #{{ $orderItem->order_id }} - {{ $orderItem->product?->name }} x {{ $orderItem->quantity }}
                <a href="{{ route('order-items.show', $orderItem) }}">Ver</a>
                <a href="{{ route('order-items.edit', $orderItem) }}">Editar</a>
                <form action="{{ route('order-items.destroy', $orderItem) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
