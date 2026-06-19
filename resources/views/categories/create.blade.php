@extends('layouts.app')

@section('title', 'Nueva categoría')

@section('content')
    <h1>Nueva categoría</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label>Nombre <input type="text" name="name" value="{{ old('name') }}" required></label><br>
        <label>Slug <input type="text" name="slug" value="{{ old('slug') }}" required></label><br>
        <label>Descripción <textarea name="description">{{ old('description') }}</textarea></label><br>
        <button type="submit">Guardar</button>
    </form>
@endsection
