@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{route('home')}}" class="btn btn-primary mb-4">Volver</a>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Status</th>
                    <th scope="col">URL de pago</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->customer_mobile }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if ($order->status === 'PAYED')
                                <p>Pagado</p>
                            @elseif($order->status === 'REJECTED')
                                <a href="{{route('orders.index')}}">Comienza de nuevo</a>
                            @else
                                <a href="{{ $order->pay_url }}">Paga la orden</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $orders->links() !!}
        </div>
    </div>
@endsection
