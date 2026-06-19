@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')
    <h1>Editar categoría</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nombre <input type="text" name="name" value="{{ old('name', $category->name) }}" required></label><br>
        <label>Slug <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required></label><br>
        <label>Descripción <textarea name="description">{{ old('description', $category->description) }}</textarea></label><br>
        <button type="submit">Actualizar</button>
    </form>
@endsection
