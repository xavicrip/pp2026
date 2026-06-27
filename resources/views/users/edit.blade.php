@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar usuario',
        'subtitle' => $user->email,
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del usuario</h2>
            <p class="mt-0.5 text-sm text-slate-500">Deja la contraseña en blanco para mantener la actual.</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name', $user->name),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'value' => old('email', $user->email),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Nueva contraseña',
                'name' => 'password',
                'type' => 'password',
            ])

            @include('partials.form-field', [
                'label' => 'Confirmar contraseña',
                'name' => 'password_confirmation',
                'type' => 'password',
            ])

            <div class="mb-5">
                <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="client" @selected(old('role', $user->role) === 'client')>Cliente</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                </select>
                @error('role')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @include('partials.form-actions', [
                'cancelUrl' => route('users.index'),
                'submitLabel' => 'Actualizar',
            ])
        </form>
    </div>
@endsection
