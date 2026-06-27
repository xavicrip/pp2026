<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Ecommerce'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold tracking-tight text-slate-900">
                {{ config('app.name', 'Ecommerce') }}
            </a>

            @auth
                <div class="flex flex-wrap items-center gap-3">
                    @if (auth()->user()->isAdmin())
                        <div class="flex flex-wrap gap-1 rounded-lg bg-slate-100 p-1 text-sm font-medium">
                            <a href="{{ route('categories.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('categories.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Categorías
                            </a>
                            <a href="{{ route('products.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('products.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Productos
                            </a>
                            <a href="{{ route('orders.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('orders.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Órdenes
                            </a>
                            <a href="{{ route('order-items.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('order-items.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Items
                            </a>
                            <a href="{{ route('users.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('users.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Usuarios
                            </a>
                        </div>
                    @else
                        <div class="flex flex-wrap gap-1 rounded-lg bg-slate-100 p-1 text-sm font-medium">
                            <a href="{{ route('client.orders.index') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('client.orders.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Mis pedidos
                            </a>
                            <a href="{{ route('profile.edit') }}"
                               class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('profile.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Mi perfil
                            </a>
                        </div>
                    @endif

                    <span class="hidden text-sm text-slate-600 sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Salir
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    @isset($header)
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-6xl px-4 py-6">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="mx-auto max-w-6xl px-4 py-8">
        @include('partials.flash')

        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>
</body>
</html>
