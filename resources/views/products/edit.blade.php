@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    <h1>Editar producto</h1>
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nombre <input type="text" name="name" value="{{ old('name', $product->name) }}" required></label><br>
        <label>Slug <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" required></label><br>
        <label>Descripción <textarea name="description">{{ old('description', $product->description) }}</textarea></label><br>
        <label>Precio <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required></label><br>
        <label>Categoría
            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))> Activo</label><br>
        <button type="submit">Actualizar</button>
    </form>
@endsection
