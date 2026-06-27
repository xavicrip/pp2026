<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_routes(): void
    {
        $this->get(route('categories.index'))->assertRedirect(route('login'));
    }

    public function test_client_cannot_access_admin_routes(): void
    {
        $client = User::factory()->client()->create();

        $this->actingAs($client)
            ->get(route('categories.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_categories(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('categories.index'))
            ->assertOk();
    }

    public function test_client_only_sees_own_orders(): void
    {
        $client = User::factory()->client()->create();
        $other = User::factory()->client()->create();

        $ownOrder = Order::factory()->create(['user_id' => $client->id]);
        $foreignOrder = Order::factory()->create(['user_id' => $other->id]);

        $this->actingAs($client)
            ->get(route('client.orders.index'))
            ->assertOk()
            ->assertSee('#'.$ownOrder->id)
            ->assertDontSee('#'.$foreignOrder->id);
    }

    public function test_client_cannot_view_foreign_order(): void
    {
        $client = User::factory()->client()->create();
        $foreignOrder = Order::factory()->create();

        $this->actingAs($client)
            ->get(route('client.orders.show', $foreignOrder))
            ->assertForbidden();
    }

    public function test_registration_creates_client_role(): void
    {
        $this->post(route('register'), [
            'name' => 'Nuevo Cliente',
            'email' => 'nuevo@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('client.orders.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@example.com',
            'role' => User::ROLE_CLIENT,
        ]);
    }
}
