@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('home')}}" class="btn btn-primary mb-4">Volver</a>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top"
                            src="{{$product->image}}"
                            alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text">
                            <p><strong>$</strong> {{$product->price}} USD</p>
                            <p>{{$product->description}}</p>
                            <a href="{{ route('orders.create',['id' => $product->id]) }}" class="btn btn-primary">Ir a producto</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
