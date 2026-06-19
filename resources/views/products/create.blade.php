@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
    <h1>Nuevo producto</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <label>Nombre <input type="text" name="name" value="{{ old('name') }}" required></label><br>
        <label>Slug <input type="text" name="slug" value="{{ old('slug') }}" required></label><br>
        <label>Descripción <textarea name="description">{{ old('description') }}</textarea></label><br>
        <label>Precio <input type="number" step="0.01" name="price" value="{{ old('price') }}" required></label><br>
        <label>Categoría
            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label><input type="checkbox" name="is_active" value="1" checked> Activo</label><br>
        <button type="submit">Guardar</button>
    </form>
@endsection
