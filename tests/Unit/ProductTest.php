<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_products_database_example()
    {
        $data = [
            'name' => 'Jorge',
            'price' => 10.00,
            'image' => 'http://example.com',
            'description' => 'Test description',
        ];
        Product::create($data);

        return $this->assertDatabaseHas('products', $data);
    }

    public function test_product_view()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $response = $this->actingAs($user)->get('/orders');
        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
        $response->assertSee('Zapato con tacon');
        $response->assertSee('Zapato de tacon hecho de piel de vaca');
        $response->assertSee('Ir a producto');
    }
}
