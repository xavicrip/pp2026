@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <h1>{{ $category->name }}</h1>
    <p>Slug: {{ $category->slug }}</p>
    <p>{{ $category->description }}</p>
    <a href="{{ route('categories.edit', $category) }}">Editar</a>
    <a href="{{ route('categories.index') }}">Volver</a>
@endsection
