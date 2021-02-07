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
                        @if ($list_product->disc==0)
                            <p><strong>Price: </strong>Rp. {{ $list_product->price }} </p>
                        @else
                            <p class="text-muted" style="text-decoration: line-through;"><strong>Price: </strong> Rp. {{ $list_product->price }} </p>
                            <p><strong>Price: </strong>Rp. {{ $list_product->price - ($list_product->price * $list_product->disc/100) }} </p>
                        @endif
                            <p class="btn-holder" ><a href="{{ url('add-to-cart/'.$list_product->id) }}" class="btn btn-primary text-center" role="button">Buy</a>
                            <a href="{{ url('detail/'.$list_product->id) }}" class="btn btn-danger  text-right" role="button">Detail</a> </p>
                    </div>
                </div>
                </div>
        </div>
        @endforeach
    </div><!-- End row -->
</div>
@endsection