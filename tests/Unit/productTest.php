<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_true_is_true(): void
    {
        // Crear un producto
        $product = Product::factory()->create();
        $this->assertNotNull($product->name);
        $this->assertNotNull($product->slug);
        $this->assertNotNull($product->description);
        $this->assertNotNull($product->price);
        $this->assertNotNull($product->created_at);
        $this->assertNotNull($product->updated_at);
    }
}
