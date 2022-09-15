<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_database_model()
    {
        $data = [
            'customer_name' => 'Jorge',
            'customer_email' => 'jorge@example.com',
            'customer_mobile' => '3314137850',
            'status' => 'PAYED',
            'user_id' => '1',
            'pay_url' => 'http://example.com',
            'order_id' => \Str::random(10),
            'request_id' => \Str::random(10),
        ];

        Order::create($data);

        return $this->assertDatabaseHas('orders', $data);
    }

    public function test_order_view()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $response = $this->actingAs($user)->get('/orders/create/1');
        $response->assertStatus(200);
        $response->assertViewIs('orders.create');
        $response->assertSee('Compra de producto');
        $response->assertSee('Producto');
        $response->assertSee('Comprar');
    }

    public function test_order_resume_view()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $response = $this->actingAs($user)->get('/orders/resume');
        $response->assertStatus(200);
        $response->assertViewIs('orders.resume');
        $response->assertSee('jorge@example.com');
        $response->assertSee('3314137850');
        $response->assertSee('PAYED');
    }
}
