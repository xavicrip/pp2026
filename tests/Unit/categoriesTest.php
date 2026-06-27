<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_true_is_true(): void
    {
        // Crear una categoría
        $category = Category::factory()->create();
        $this->assertNotNull($category->name);
        $this->assertNotNull($category->slug);
        $this->assertNotNull($category->description);
        $this->assertNotNull($category->created_at);
        $this->assertNotNull($category->updated_at);
    }
}
