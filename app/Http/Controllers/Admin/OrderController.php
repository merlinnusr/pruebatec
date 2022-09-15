<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(
      OrderRepositoryInterface $orderRepository,
      ) {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate(15);

        return view('admin.orders', ['orders' => $orders]);
    }
}
