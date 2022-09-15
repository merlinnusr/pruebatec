<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\API\PlaceToPay\PlacetopayService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $productRepository;

    private $orderRepository;

    public function __construct(
    OrderRepositoryInterface $orderRepository,
    ProductRepositoryInterface $productRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $products = $this->productRepository->all();

        return view('orders.index', ['products' => $products]);
    }

    public function create($id)
    {
        return view('orders.create', ['productId' => $id]);
    }

    public function confirmBuy(Request $request)
    {
        $data = $request->all();

        return view('orders.confirm_purchase', ['orders' => $data]);
    }

    public function store(OrderStoreRequest $request)
    {
        $orderId = \Str::random(10);

        $data = $request->validated();
        $product = $this->productRepository->find($data['productId']);

        $placeToPayResponse = (new PlacetopayService())->createSession(
            $orderId,
            $product->description,
            'USD',
            $product->price
        );
        if (empty($placeToPayResponse['requestId'])) {
            return back()->withErrors('Error al comunicarse con la API de pagos');
        }

        $order = $this->orderRepository->create([
            'user_id' => auth()->id(),
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_mobile' => $data['phone'],
            'status' => 'CREATED',
            'pay_url' => $placeToPayResponse['processUrl'],
            'order_id' => $orderId,
            'request_id' => $placeToPayResponse['requestId'],
        ]);
        if (empty($order->id)) {
            return back()->withErrors('Error al guardar tu registro');
        }

        return redirect($placeToPayResponse['processUrl']);
    }

    public function callbackSuccess($orderId)
    {
        $order = $this->orderRepository->where(['order_id', $orderId])->first();
        $responseCheckSession = (new PlacetopayService())
          ->checkSession($order->requestId);
        if ($responseCheckSession['status']['status'] === 'APPROVED') {
            $order->status = 'PAYED';
            $order->save();
        }

        if ($responseCheckSession['status']['status'] === 'REJECTED') {
            $order->status = 'REJECTED';
            $order->save();
        }

        return redirect()->route('orders.resume');
    }

    public function resume()
    {
        (new OrderService($this->orderRepository))->update();
        $orders = $this->orderRepository->paginate(15);

        return view('orders.resume', compact('orders'));
    }
}
