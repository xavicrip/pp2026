<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();

        return view('orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Orden creada correctamente');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $users = User::all();

        return view('orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Orden actualizada correctamente');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Orden eliminada correctamente');
    }

    public function clientIndex()
    {
        $orders = auth()->user()->orders()->latest()->get();

        return view('client.orders.index', compact('orders'));
    }

    public function clientShow(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.product']);

        return view('client.orders.show', compact('order'));
    }
}
