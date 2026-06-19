<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce')</title>
</head>
<body>
    <nav>
        <a href="{{ route('categories.index') }}">Categorías</a> |
        <a href="{{ route('products.index') }}">Productos</a> |
        <a href="{{ route('orders.index') }}">Órdenes</a> |
        <a href="{{ route('order-items.index') }}">Items</a>
    </nav>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @yield('content')
</body>
</html>
