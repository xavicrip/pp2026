# Guía paso a paso: mejorar las vistas del ecommerce

Esta guía describe cómo mejorar la interfaz del proyecto Laravel **sin cambiar la lógica de negocio**. El proyecto ya tiene **Tailwind CSS 4** y **Vite** configurados, pero las vistas CRUD (`categories`, `products`, `orders`, `order-items`) usan HTML básico sin estilos.

> **Nota:** Esta carpeta (`docs/`) está en `.gitignore`. Es documentación local de referencia.
>
> **Validada:** los pasos de esta guía fueron aplicados de principio a fin y producen el diseño admin slate descrito (nav con pestañas, tablas, formularios con pie de acciones visible).

---

## Estado actual

| Elemento | Situación |
|----------|-----------|
| Layout | `resources/views/layouts/app.blade.php` — HTML mínimo, sin `@vite` |
| Estilos | `resources/css/app.css` — Tailwind importado, pero no cargado en el layout |
| Vistas CRUD | Listas en `<ul>`, formularios con `<br>`, sin errores de validación visibles |
| Componentes | No hay partials ni Blade components reutilizables |

**Archivos afectados (18 vistas):**

```
resources/views/layouts/app.blade.php
resources/views/categories/*.blade.php   (4 archivos)
resources/views/products/*.blade.php     (4 archivos)
resources/views/orders/*.blade.php       (4 archivos)
resources/views/order-items/*.blade.php  (4 archivos)
```

---

## Principios de diseño

Esta guía usa un estilo **admin limpio** (slate + acentos oscuros). Reglas clave para que nada “se pierda” en pantalla:

| Regla | Por qué |
|-------|---------|
| **Botones de formulario siempre en un pie de tarjeta** (`form-actions`) | Separados del último campo con borde y fondo distinto; no quedan pegados al checkbox |
| **Tarjetas en 3 zonas**: encabezado → campos → acciones | El usuario ve dónde empieza y termina el formulario |
| **Enlaces de tabla como botones pequeños**, no solo texto | “Ver / Editar / Eliminar” se distinguen del contenido |
| **Navegación con pestañas** (fondo `slate-100`) | La sección activa se nota de inmediato |
| **Encabezado con enlace “Volver”** en create/edit | No hay que depender solo del nav superior |

Paleta base: `slate-*` para texto y bordes, `slate-900` para acciones primarias (más contraste que `indigo-600` sobre fondo gris).

---

## Paso 0: requisitos previos

Antes de editar vistas, asegúrate de que los assets se compilan:

```bash
npm install
npm run dev
```

En otra terminal:

```bash
php artisan serve
```

Si usas producción:

```bash
npm run build
```

---

## Paso 1: conectar Vite y Tailwind al layout

**Archivo:** `resources/views/layouts/app.blade.php`

Agrega la directiva `@vite` dentro de `<head>` y clases base en `<body>`. El contenido del `<body>` (navegación y `@yield`) se completa en el **Paso 3**, después de crear los partials del **Paso 2**:

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    {{-- Paso 3: aquí van <nav>, <main> y @include('partials.flash') --}}
</body>
</html>
```

**Verificación:** al recargar cualquier página CRUD, el fondo debe verse gris claro (no blanco plano sin estilos).

---

## Paso 2: crear partials reutilizables

> **Importante:** crea estos archivos **antes** de usar `@include('partials.flash')` en el layout. Si incluyes un partial que aún no existe, Laravel lanzará `View [partials.flash] not found`.

Crea la carpeta `resources/views/partials/` con componentes pequeños que evitan repetir HTML en las 16 vistas CRUD.

### 2.1 Mensajes flash — `partials/flash.blade.php`

```blade
@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900" role="alert">
        <span class="mt-0.5 text-emerald-600" aria-hidden="true">✓</span>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900" role="alert">
        <span class="mt-0.5 text-red-600" aria-hidden="true">!</span>
        <p class="text-sm font-medium">{{ session('error') }}</p>
    </div>
@endif
```

### 2.2 Encabezado de página — `partials/page-header.blade.php`

Soporta título, subtítulo, enlace “Volver” (formularios) y botón de acción (listados):

```blade
<div class="mb-8">
    @if (!empty($backUrl))
        <a href="{{ $backUrl }}"
           class="mb-3 inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900">
            <span aria-hidden="true">←</span> {{ $backLabel ?? 'Volver' }}
        </a>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            @if (!empty($subtitle))
                <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>

        @if (!empty($actionUrl) && !empty($actionLabel))
            <a href="{{ $actionUrl }}"
               class="inline-flex shrink-0 items-center justify-center gap-1 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                <span aria-hidden="true">+</span> {{ $actionLabel }}
            </a>
        @endif
    </div>
</div>
```

Uso en **index**:

```blade
@include('partials.page-header', [
    'title' => 'Productos',
    'subtitle' => 'Catálogo de productos del ecommerce',
    'actionUrl' => route('products.create'),
    'actionLabel' => 'Nuevo producto',
])
```

Uso en **create / edit** (con enlace de regreso):

```blade
@include('partials.page-header', [
    'title' => 'Nuevo producto',
    'subtitle' => 'Completa los datos para publicar en el catálogo',
    'backUrl' => route('products.index'),
    'backLabel' => 'Volver a productos',
])
```

### 2.3 Acciones de formulario — `partials/form-actions.blade.php`

> **Clave:** coloca este partial **al final del `<form>`**, dentro de la tarjeta. El pie con fondo `slate-50` hace que Guardar y Cancelar no se pierdan entre los campos.

```blade
<div class="mt-8 -mx-6 -mb-6 flex flex-col-reverse gap-3 rounded-b-xl border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
    <a href="{{ $cancelUrl }}"
       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
        {{ $cancelLabel ?? 'Cancelar' }}
    </a>
    <button type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
        {{ $submitLabel ?? 'Guardar' }}
    </button>
</div>
```

Los márgenes negativos (`-mx-6 -mb-6`) alinean el pie con los bordes de la tarjeta que usa `p-6`.

### 2.4 Botones de tabla — `partials/action-buttons.blade.php`

Botones compactos con fondo, más visibles que enlaces de texto:

```blade
<div class="inline-flex flex-wrap items-center justify-end gap-1">
    <a href="{{ $showUrl }}"
       class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
        Ver
    </a>
    <a href="{{ $editUrl }}"
       class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
        Editar
    </a>
    <form action="{{ $destroyUrl }}" method="POST" class="inline"
          onsubmit="return confirm('{{ $confirmMessage ?? '¿Eliminar este registro?' }}')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
            Eliminar
        </button>
    </form>
</div>
```

### 2.5 Campo de formulario — `partials/form-field.blade.php`

Créalo junto con los demás partials del Paso 2 (antes de editar create/edit):

```blade
@php
    $inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200';
@endphp

<div class="mb-5">
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-slate-700">
        {{ $label }}
        @if (!empty($required))<span class="text-red-500">*</span>@endif
    </label>

    @if (($type ?? 'text') === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
                  class="{{ $inputClass }}"
                  @if (!empty($required)) required @endif>{{ $value ?? '' }}</textarea>
    @else
        <input type="{{ $type ?? 'text' }}" id="{{ $name }}" name="{{ $name }}"
               value="{{ $value ?? '' }}"
               class="{{ $inputClass }}"
               @if (!empty($required)) required @endif
               @if (!empty($step)) step="{{ $step }}" @endif
               @if (!empty($min)) min="{{ $min }}" @endif>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
```

**Resumen de archivos del Paso 2** (todos en `resources/views/partials/`):

| Archivo | Uso |
|---------|-----|
| `flash.blade.php` | Mensajes success/error en el layout |
| `page-header.blade.php` | Título, subtítulo, Volver, botón de acción |
| `form-actions.blade.php` | Pie de formulario con Guardar / Cancelar |
| `action-buttons.blade.php` | Ver / Editar / Eliminar en tablas |
| `form-field.blade.php` | Inputs y textareas con `@error` |

---

## Paso 3: mejorar la navegación y el contenedor principal

Sustituye el `<nav>` y el contenido del `<body>` del layout por una barra con Tailwind. Mantén las mismas rutas.

**Elimina** del layout antiguo:
- cualquier bloque suelto `@if (session('success'))` (los mensajes pasan al partial del Paso 2.1)
- un segundo `@yield('content')` si quedó duplicado al pegar fragmentos

Dentro de `<body>`, usa navegación con **pestañas** (la activa lleva fondo blanco y sombra):

```blade
<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
        <a href="{{ route('categories.index') }}" class="text-lg font-bold tracking-tight text-slate-900">
            Ecommerce
        </a>
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
        </div>
    </div>
</nav>

<main class="mx-auto max-w-6xl px-4 py-8">
    @include('partials.flash')

    @yield('content')
</main>
```

**Layout completo de referencia** (`resources/views/layouts/app.blade.php`):

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('categories.index') }}" class="text-lg font-bold tracking-tight text-slate-900">
                Ecommerce
            </a>
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
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @include('partials.flash')

        @yield('content')
    </main>
</body>
</html>
```

**Verificación:** al recargar cualquier página CRUD, no debe aparecer el error `View [partials.flash] not found` y la navegación debe verse con estilos Tailwind.

---

## Paso 4: convertir listas en tablas responsivas

**Ejemplo:** `resources/views/products/index.blade.php`

**Antes:** lista `<ul>` sin estructura.

**Después:**

```blade
@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    @include('partials.page-header', [
        'title' => 'Productos',
        'subtitle' => 'Catálogo de productos del ecommerce',
        'actionUrl' => route('products.create'),
        'actionLabel' => 'Nuevo producto',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Precio</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-5 py-4 tabular-nums text-slate-600">${{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('products.show', $product),
                                    'editUrl' => route('products.edit', $product),
                                    'destroyUrl' => route('products.destroy', $product),
                                    'confirmMessage' => '¿Eliminar este producto?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay productos registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primero desde el botón “Nuevo producto”.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
```

**Repite el mismo patrón** en:

| Vista | Columnas sugeridas |
|-------|-------------------|
| `categories/index` | Nombre, Slug, Acciones |
| `orders/index` | ID, Estado, Total, Fecha, Acciones |
| `order-items/index` | Orden, Producto, Cantidad, Subtotal, Acciones |

### 4.1 `categories/index` — columnas Nombre, Slug, Acciones

Mismo patrón que productos: `page-header` + tabla con `@forelse` y `action-buttons`. Cambia rutas y mensajes de confirmación a `categories.*`.

### 4.2 `orders/index` — badges de estado

En la columna Estado, usa un badge con colores según el valor:

```blade
@php
    $statusClasses = match ($order->status) {
        'completed', 'delivered' => 'bg-emerald-100 text-emerald-800',
        'cancelled' => 'bg-red-100 text-red-800',
        'processing', 'shipped' => 'bg-blue-100 text-blue-800',
        default => 'bg-amber-100 text-amber-800',
    };
@endphp
<span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
    {{ $order->status }}
</span>
```

Columnas: ID (`#{{ $order->id }}`), Estado (badge), Total (`number_format`), Fecha (`$order->created_at?->format('d/m/Y H:i')`).

### 4.3 `order-items/index` — relaciones

Muestra datos relacionados con fallback:

```blade
{{ $orderItem->product?->name ?? 'Producto eliminado' }}
```

El controlador ya debe cargar relaciones: `OrderItem::with(['order', 'product'])->get()`.

---

## Paso 5: mejorar formularios (create / edit)

### 5.1 Patrón de tarjeta de formulario

Toda vista create/edit sigue esta estructura:

1. `@include('partials.page-header')` con `backUrl` y `backLabel`
2. Tarjeta `max-w-2xl overflow-hidden rounded-xl border ...`
3. Encabezado interno (`border-b`) con título y nota de campos obligatorios
4. `<form class="p-6">` con campos (`form-field` o `<select>` manual con las mismas clases)
5. `@include('partials.form-actions')` **al final del form**, dentro de la tarjeta

Los `<select>` que no usan `form-field` comparten esta clase:

```blade
class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
```

### 5.2 Ejemplo completo — `products/create.blade.php`

Estructura en **tarjeta de 3 zonas**: encabezado interno → campos → `@include('partials.form-actions')`. Los botones van en el pie gris, no después del checkbox sin separación.

```blade
@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nuevo producto',
        'subtitle' => 'Completa los datos para publicar en el catálogo',
        'backUrl' => route('products.index'),
        'backLabel' => 'Volver a productos',
    ])

    <div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del producto</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="p-6">
            @csrf

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Slug',
                'name' => 'slug',
                'value' => old('slug'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Descripción',
                'name' => 'description',
                'type' => 'textarea',
                'value' => old('description'),
            ])

            @include('partials.form-field', [
                'label' => 'Precio',
                'name' => 'price',
                'type' => 'number',
                'value' => old('price'),
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ])

            <div class="mb-5">
                <label for="category_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       @checked(old('is_active', true))
                       class="size-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                <label for="is_active" class="text-sm font-medium text-slate-700">Producto activo en el catálogo</label>
            </div>

            @include('partials.form-actions', [
                'cancelUrl' => route('products.index'),
                'submitLabel' => 'Guardar producto',
            ])
        </form>
    </div>
@endsection
```

> **Tip:** en `edit.blade.php`, usa `old('name', $model->name)` y `form-actions` con `submitLabel` => `'Actualizar ...'`.

### 5.3 Ejemplo corto — `categories/create.blade.php`

Mismo patrón de tarjeta; solo cambian los campos (nombre, slug, descripción) y las rutas:

```blade
@include('partials.page-header', [
    'title' => 'Nueva categoría',
    'subtitle' => 'Define una categoría para agrupar productos',
    'backUrl' => route('categories.index'),
    'backLabel' => 'Volver a categorías',
])

<div class="max-w-2xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="text-base font-semibold text-slate-900">Datos de la categoría</h2>
        <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
    </div>
    <form action="{{ route('categories.store') }}" method="POST" class="p-6">
        @csrf
        {{-- form-field: name, slug, description --}}
        @include('partials.form-actions', [
            'cancelUrl' => route('categories.index'),
            'submitLabel' => 'Guardar categoría',
        ])
    </form>
</div>
```

### 5.4 Replicar en orders y order-items

- **orders/create y edit:** campos `user_id` (select), `status`, `subtotal`, `tax`, `total`, `shipping_address`
- **order-items/create y edit:** campos `order_id` (select), `product_id` (select), `quantity`, `unit_price`, `subtotal`

En todos los casos: misma tarjeta, mismo `form-actions`, `backUrl` al index correspondiente.

> **Formularios largos:** si el pie queda fuera de pantalla al hacer scroll, añade `sticky bottom-0 z-10 backdrop-blur-sm bg-slate-50/95` al `div` de `form-actions`.

---

## Paso 6: mejorar vistas de detalle (show)

**Ejemplo:** `resources/views/products/show.blade.php`

```blade
@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @include('partials.page-header', [
        'title' => $product->name,
        'subtitle' => 'Detalle del producto',
        'backUrl' => route('products.index'),
        'backLabel' => 'Volver a productos',
    ])

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Producto</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $product->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">Slug: {{ $product->slug }}</p>
            </div>
            <a href="{{ route('products.edit', $product) }}"
               class="inline-flex shrink-0 items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Editar producto
            </a>
        </div>

        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Precio</dt>
                <dd class="mt-2 text-2xl font-bold tabular-nums text-slate-900">
                    ${{ number_format($product->price, 2) }}
                </dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</dt>
                <dd class="mt-2 text-base font-medium text-slate-900">{{ $product->category?->name ?? '—' }}</dd>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                <dd class="mt-2">
                    @if ($product->is_active)
                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                            Activo
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">
                            Inactivo
                        </span>
                    @endif
                </dd>
            </div>
        </dl>

        @if ($product->description)
            <div class="border-t border-slate-200 px-6 py-6">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripción</h2>
                <p class="mt-2 leading-relaxed text-slate-700">{{ $product->description }}</p>
            </div>
        @endif
    </div>
@endsection
```

Usa `<dl>` con mini-tarjetas para datos estructurados y badges para estados.

### 6.1 Ejemplo — `orders/show.blade.php`

Incluye badges de estado (mismo `match` del Paso 4.2), mini-tarjetas para totales y tabla de items:

```blade
@include('partials.page-header', [
    'title' => 'Orden #' . $order->id,
    'subtitle' => 'Detalle del pedido',
    'backUrl' => route('orders.index'),
    'backLabel' => 'Volver a órdenes',
])

{{-- Tarjeta con dl de subtotal/total/estado --}}
{{-- Sección inferior: tabla de $order->items con product?->name --}}
```

El controlador en `show` debe hacer: `$order->load(['user', 'items.product'])`.

---

## Paso 7: estados vacíos y relaciones

Cuando un listado depende de relaciones (p. ej. `order-items` con orden y producto), asegúrate de que el controlador use `with()`:

```php
// En el controlador (referencia, no es una vista)
OrderItem::with(['order', 'product'])->get();
```

En la vista, muestra datos relacionados con fallback:

```blade
{{ $orderItem->product?->name ?? 'Producto eliminado' }}
```

---

## Paso 8 (opcional): paginación

Si los listados crecen, cambia en el controlador:

```php
$products = Product::with('category')->latest()->paginate(15);
```

En la vista index, al final de la tabla:

```blade
<div class="border-t border-slate-200 px-4 py-3">
    {{ $products->links() }}
</div>
```

Tailwind ya está configurado para las vistas de paginación de Laravel en `app.css` (línea `@source` de Pagination).

---

## Paso 9 (opcional): página de inicio del admin

Puedes redirigir la ruta `/` a categorías o crear un dashboard simple en `welcome.blade.php` o una nueva vista `dashboard.blade.php` con tarjetas de acceso rápido:

```blade
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <a href="{{ route('products.index') }}"
       class="group rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-slate-300 hover:shadow-md">
        <h2 class="font-semibold text-slate-900 group-hover:text-slate-700">Productos</h2>
        <p class="mt-1 text-sm text-slate-500">Gestionar catálogo</p>
    </a>
    {{-- más tarjetas --}}
</div>
```

---

## Orden recomendado de implementación

Sigue este orden para ver resultados rápidos y evitar rework:

```
1. Paso 0              → npm install, npm run dev, php artisan serve
2. Paso 2 (completo)   → 5 partials en resources/views/partials/
3. Paso 3              → layout completo (reemplaza app.blade.php)
4. products/index      → plantilla de tabla (Paso 4)
5. products/create     → plantilla de formulario (Paso 5)
6. products/edit       → copiar create, old() con modelo, PUT
7. products/show       → plantilla de detalle (Paso 6)
8. categories          → replicar 4 vistas (Pasos 4.1, 5.3, 6)
9. orders              → replicar + badges (Pasos 4.2, 5.4, 6.1)
10. order-items        → replicar + relaciones (Pasos 4.3, 5.4, 6)
11. npm run build      → si no usas npm run dev, compila antes de revisar
12. Paginación/dashboard → opcional (Pasos 8–9)
```

---

## Verificación del resultado

Al terminar todos los pasos, estas URLs deben verse con el diseño slate (nav con pestañas, tablas, formularios con pie de botones):

| URL | Qué revisar |
|-----|-------------|
| `/categories` | Tabla, botón “+ Nueva categoría”, nav activo |
| `/products` | Tabla con precios formateados |
| `/products/create` | Tarjeta, campos estilizados, **pie gris con Guardar / Cancelar** |
| `/products/1` | Mini-tarjetas, badge Activo/Inactivo |
| `/orders` | Badges de estado por color |
| `/order-items` | Columnas de orden y producto |

Si no ves estilos: confirma que `npm run dev` está activo **o** ejecutaste `npm run build` después de los cambios.

---

## Checklist de calidad

Antes de dar por terminada la mejora visual, revisa:

- [ ] `@vite` cargado en el layout
- [ ] Navegación con pestañas y sección activa visible
- [ ] Mensajes `success` y `error` visibles y legibles
- [ ] Formularios usan `partials/form-actions` (pie gris con Guardar / Cancelar)
- [ ] Create/edit tienen enlace “Volver” en `page-header`
- [ ] Formularios muestran `@error` bajo cada campo
- [ ] Botón "Cancelar" vuelve al index correspondiente
- [ ] Eliminar pide confirmación (`confirm()` o modal)
- [ ] Tablas con scroll horizontal en móvil (`overflow-x-auto`)
- [ ] Acciones de tabla distinguibles (no solo texto plano)
- [ ] Precios formateados con `number_format($valor, 2)`
- [ ] Estados vacíos con `@forelse` / `@empty` y mensaje útil
- [ ] `npm run dev` activo durante desarrollo

---

## Personalización de tema (opcional)

En `resources/css/app.css` ya existe un bloque `@theme`. Puedes ajustar colores primarios:

```css
@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
    --color-primary: oklch(0.55 0.2 264); /* indigo aproximado */
}
```

Luego usa utilidades como `bg-primary` si defines la variable, o mantén las clases `slate-*` de esta guía para un aspecto más neutro y profesional.

---

## Recursos útiles

- [Tailwind CSS v4 — documentación](https://tailwindcss.com/docs)
- [Laravel Blade — documentación](https://laravel.com/docs/blade)
- [Laravel Vite — documentación](https://laravel.com/docs/vite)
- [Validación y @error — Laravel](https://laravel.com/docs/validation#quick-displaying-the-validation-errors)
