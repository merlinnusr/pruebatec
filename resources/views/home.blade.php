@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-primary"  href="{{ route('orders.index') }}">Ver productos</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary" href="{{route('orders.resume')}}">Ver ordenes/Status de ordenes</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
