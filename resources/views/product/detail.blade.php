@extends('layouts.app')
@section('title' , 'DETAIL PRODUCT')
@section('content')
<div class="container">
    <h2>Product Detail</h2>
    <div class="row">
        <div class="col-md-3 mt-3">
            <div class="card-group">
                <div class="card" style="width: 15rem;">
                    <div class="col-sm-4 hidden-xs">
                        <img src="{{ $product->photo }}" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text"> {{ \Illuminate\Support\Str::limit(strtolower($product->description), 50, $end='...') }}</p>
                        @if ($product->disc==0)
                            <p><strong>Price: </strong>Rp. {{ $product->price }} </p>
                        @else
                            <p class="text-muted" style="text-decoration: line-through;"><strong>Price: </strong> Rp. {{ $product->price }} </p>
                            <p><strong>Price: </strong>Rp. {{ $product->price - ($product->price * $product->disc/100) }} </p>
                        @endif
                            <p class="btn-holder" ><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-primary text-center" role="button">Buy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
