<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();

        return view('order-items.index', compact('orderItems'));
    }

    public function create()
    {
        $orders = Order::all();
        $products = Product::all();

        return view('order-items.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        OrderItem::create($validated);

        return redirect()->route('order-items.index')->with('success', 'Item de orden creado correctamente');
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);

        return view('order-items.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        $orders = Order::all();
        $products = Product::all();

        return view('order-items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $orderItem->update($validated);

        return redirect()->route('order-items.index')->with('success', 'Item de orden actualizado correctamente');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()->route('order-items.index')->with('success', 'Item de orden eliminado correctamente');
    }
}
