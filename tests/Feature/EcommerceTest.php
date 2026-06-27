<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_models_and_relationships_work(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Tech products',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Phone',
            'slug' => 'phone',
            'description' => 'Smartphone',
            'price' => 999.99,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 999.99,
            'tax' => 99.99,
            'total' => 1099.98,
            'shipping_address' => '123 Main St',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 999.99,
            'subtotal' => 999.99,
        ]);

        $this->assertCount(1, $category->products);
        $this->assertCount(1, $user->orders);
        $this->assertCount(1, $order->items);
        $this->assertSame('Phone', $orderItem->product->name);
        $this->assertSame('Electronics', $product->category->name);
    }

    public function test_category_crud_routes_work(): void
    {
        $this->actingAsAdmin();

        $this->get(route('categories.index'))->assertOk();
        $this->get(route('categories.create'))->assertOk();

        $this->post(route('categories.store'), [
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Reading',
        ])->assertRedirect(route('categories.index'));

        $category = Category::first();
        $this->assertNotNull($category);

        $this->get(route('categories.show', $category))->assertOk();
        $this->get(route('categories.edit', $category))->assertOk();

        $this->put(route('categories.update', $category), [
            'name' => 'Books Updated',
            'slug' => 'books-updated',
            'description' => 'Updated',
        ])->assertRedirect(route('categories.index'));

        $this->assertSame('Books Updated', $category->fresh()->name);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_product_store_requires_valid_category(): void
    {
        $this->actingAsAdmin();

        $category = Category::create([
            'name' => 'Home',
            'slug' => 'home',
            'description' => null,
        ]);

        $this->post(route('products.store'), [
            'name' => 'Lamp',
            'slug' => 'lamp',
            'description' => 'Desk lamp',
            'price' => 49.99,
            'category_id' => $category->id,
            'is_active' => 1,
        ])->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'slug' => 'lamp',
            'category_id' => $category->id,
        ]);
    }

    public function test_order_and_order_item_controllers_work(): void
    {
        $this->actingAsAdmin();

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech', 'description' => null]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Tablet',
            'slug' => 'tablet',
            'description' => null,
            'price' => 300,
            'is_active' => true,
        ]);

        $this->post(route('orders.store'), [
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 300,
            'tax' => 30,
            'total' => 330,
            'shipping_address' => '456 Oak Ave',
        ])->assertRedirect(route('orders.index'));

        $order = Order::first();
        $this->assertNotNull($order);

        $this->post(route('order-items.store'), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 150,
            'subtotal' => 300,
        ])->assertRedirect(route('order-items.index'));

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }
}
