@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('orders.index')}}" class="btn btn-primary mb-4">Volver</a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Compra de producto') }}</div>

                    <div class="card-body">
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
                            <p>Producto</p>
                            <img height="131"
                                src="https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/mg/gm/3pp/asr/804e5626-a480-4edd-bcda-05bd6a58c993.a4ab541589b6d8b44af0972328603988.jpeg?odnHeight=2000&odnWidth=2000&odnBg=ffffff"
                                alt="Product">
                            <p><strong>$</strong> 10.00 USD</p>
                        </div>
                        <form action="{{ route('orders.confirm_buy') }}" method="GET">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input class="form-control" id="name" type="text" name="name"
                                    placeholder="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    placeholder="Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefono</label>
                                <input class="form-control" id="phone" type="tel" name="phone"
                                    placeholder="Telefono" required/>
                            </div>
                            <input type="hidden" name="productId" value="{{ $productId }}">
                            <button type="submit" class="btn btn-primary mt-3">
                                Comprar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
