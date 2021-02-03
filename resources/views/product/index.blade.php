@extends('layouts.app')
@section('title' , 'PRODUCT')
@section('content')
<div class="container products">
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif
    <div class="row ">
        @foreach($product as $list_product)
        <div class="col-md-3 mt-3">
            <div class="card-group">
                <div class="card" style="width: 15rem;">
                    <div class="col-sm-4 hidden-xs">
                        <img src="{{ $list_product->photo }}" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $list_product->name }}</h5>
                        <p class="card-text"> {{ \Illuminate\Support\Str::limit(strtolower($list_product->description), 50, $end='...') }}</p>
                        <p><strong>Price: </strong> {{ $list_product->price }} $</p>
                        <p class="btn-holder" ><a href="{{ url('add-to-cart/'.$list_product->id) }}" class="btn btn-primary btn-block text-center" role="button">Add to cart</a> </p>
                    </div>
                </div>
                </div>
        </div>
        @endforeach
    </div><!-- End row -->
</div>
@endsection