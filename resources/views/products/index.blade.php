@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <h1>Productos</h1>
    <a href="{{ route('products.create') }}">Nuevo producto</a>
    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product->name }} - ${{ $product->price }}
                <a href="{{ route('products.show', $product) }}">Ver</a>
                <a href="{{ route('products.edit', $product) }}">Editar</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
