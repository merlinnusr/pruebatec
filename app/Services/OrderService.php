<?php

namespace App\Services;

use App\Repositories\OrderRepositoryInterface;
use App\Services\API\PlaceToPay\PlacetopayService;

class OrderService
{
    private $orderRepository;

    public function __construct(
      OrderRepositoryInterface $orderRepository,
      ) {
        $this->orderRepository = $orderRepository;
    }

    public function update()
    {
        $orders = $this->orderRepository->where([
            ['status' => 'CREATED'],
            ['user_id', auth()->id()],
        ])
        ->get();
        if (! $orders->isEmpty()) {
            foreach ($orders as $order) {
                $response = (new PlacetopayService)->checkSession($order->request_id);
                if ($response['status']['status'] === 'APPROVED') {
                    $order->status = 'PAYED';
                    $order->save();
                }

                if ($response['status']['status'] === 'REJECTED') {
                    $order->status = 'REJECTED';
                    $order->save();
                }
            }
        }
    }
}
