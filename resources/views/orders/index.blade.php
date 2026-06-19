@extends('layouts.app')

@section('title', 'Órdenes')

@section('content')
    <h1>Órdenes</h1>
    <a href="{{ route('orders.create') }}">Nueva orden</a>
    <ul>
        @foreach ($orders as $order)
            <li>
                #{{ $order->id }} - {{ $order->status }} - ${{ $order->total }}
                <a href="{{ route('orders.show', $order) }}">Ver</a>
                <a href="{{ route('orders.edit', $order) }}">Editar</a>
                <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
