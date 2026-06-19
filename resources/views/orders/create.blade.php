@extends('layouts.app')

@section('title', 'Nueva orden')

@section('content')
    <h1>Nueva orden</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <label>Usuario
            <select name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </label><br>
        <label>Estado <input type="text" name="status" value="{{ old('status', 'pending') }}" required></label><br>
        <label>Subtotal <input type="number" step="0.01" name="subtotal" value="{{ old('subtotal') }}" required></label><br>
        <label>Impuesto <input type="number" step="0.01" name="tax" value="{{ old('tax') }}" required></label><br>
        <label>Total <input type="number" step="0.01" name="total" value="{{ old('total') }}" required></label><br>
        <label>Dirección <input type="text" name="shipping_address" value="{{ old('shipping_address') }}"></label><br>
        <button type="submit">Guardar</button>
    </form>
@endsection
