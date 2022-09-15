<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertSee('Dashboard');
        $response->assertSee('Ver productos');
        $response->assertSee('Ver ordenes/Status de ordenes');
    }
}
