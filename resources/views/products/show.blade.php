@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <h1>{{ $product->name }}</h1>
    <p>Precio: ${{ $product->price }}</p>
    <p>Categoría: {{ $product->category?->name }}</p>
    <p>{{ $product->description }}</p>
    <a href="{{ route('products.edit', $product) }}">Editar</a>
    <a href="{{ route('products.index') }}">Volver</a>
@endsection
