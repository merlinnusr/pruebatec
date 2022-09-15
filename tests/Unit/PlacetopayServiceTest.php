<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\API\PlaceToPay\PlacetopayService;
use Tests\TestCase;

class PlacetopayServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ok_api_response()
    {
        $response = (new PlacetopayService)->createSession(
            '123456',
            'Tenis',
            'USD',
            10
        );

        return $this->assertEquals('OK', $response['status']['status']);
    }

    public function test_error_api_response()
    {
        $response = (new PlacetopayService)->createSession(
            '123456',
            'Tenis',
            'USD123',
            10
        );

        return $this->assertEquals('FAILED', $response['status']['status']);
    }

    public function test_ok_api_check_session_failed()
    {
        $order = Order::first();
        $response = (new PlacetopayService)->checkSession($order->request_id);
        $this->assertEquals('FAILED', $response['status']['status']);
    }
}
