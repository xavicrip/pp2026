@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <h1>Categorías</h1>
    <a href="{{ route('categories.create') }}">Nueva categoría</a>
    <ul>
        @foreach ($categories as $category)
            <li>
                {{ $category->name }}
                <a href="{{ route('categories.show', $category) }}">Ver</a>
                <a href="{{ route('categories.edit', $category) }}">Editar</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
