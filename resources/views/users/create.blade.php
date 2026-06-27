@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nuevo usuario',
        'subtitle' => 'Crea un administrador o cliente',
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del usuario</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-6">
            @csrf

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'value' => old('email'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Contraseña',
                'name' => 'password',
                'type' => 'password',
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Confirmar contraseña',
                'name' => 'password_confirmation',
                'type' => 'password',
                'required' => true,
            ])

            <div class="mb-5">
                <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="client" @selected(old('role', 'client') === 'client')>Cliente</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrador</option>
                </select>
                @error('role')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @include('partials.form-actions', [
                'cancelUrl' => route('users.index'),
                'submitLabel' => 'Guardar',
            ])
        </form>
    </div>
@endsection
