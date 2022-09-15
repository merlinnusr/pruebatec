@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('orders.index') }}" class="btn btn-primary mb-4">Volver</a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Compra de producto') }}</div>

                    <div class="card-body text-center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-center">
                            <img height="131"
                                src="https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/mg/gm/3pp/asr/804e5626-a480-4edd-bcda-05bd6a58c993.a4ab541589b6d8b44af0972328603988.jpeg?odnHeight=2000&odnWidth=2000&odnBg=ffffff"
                                alt="Product">
                            <p>Producto: {{ $orders['name'] }}</p>
                            <p>Precio: <strong>$</strong> 10.00 USD</p>
                            <p>Email : {{ $orders['email'] }}</p>
                            <p>Telefono : {{ $orders['phone'] }}</p>

                        </div>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="name" name="name" value="{{ $orders['name'] }}" />
                            <input type="hidden" id="email" name="email" value="{{ $orders['email'] }}" />
                            <input type="hidden" id="phone" name="phone" value="{{ $orders['phone'] }}" />
                            <input type="hidden" name="productId" value="{{ $orders['productId'] }}" />
                            <button type="submit" class="btn btn-primary mt-3 mx-auto text-center" style="text-align: center!important;">
                                Comprar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
