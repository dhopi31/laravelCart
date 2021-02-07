@extends('layouts.app')
@section('title' , 'CART REFRESH')
@section('content')
<div class="container">
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
            <?php $total = 0 ?>
            @if(session('cart'))
            
            @foreach(session('cart') as $id => $details)
            @if ($details['disc']==0)
                <?php $total += $details['price'] * $details['quantity'] ?>
            @else
                <?php $total += ($details['price'] - ($details['price'] * $details['disc']/100)) * $details['quantity'] ?>
            @endif

            <tr>    
                <form action="check-out" method="POST">                   
                    <td data-th="Product">
                        <input type="hidden" name="item_code[]" value="{{ $id }}">
                        <input type="hidden" name="total" value="{{ $total }}"> 
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>

                    <td data-th="Price">
                        @if ($details['disc']==0)
                            Rp. {{ $details['price'] }}
                        @else
                            Rp. {{ $details['price'] - ($details['price'] * $details['disc']/100) }}
                        @endif
                    </td>

                    <td data-th="Quantity">
                        <input type="number" name="qty[]" value="{{ $details['quantity'] }}" class="form-control quantity" min='1' />
                    </td>
                    
                    <td data-th="Subtotal" class="text-center">
                        @if ($details['disc']==0)
                            Rp. {{ $details['price'] * $details['quantity'] }}
                        @else
                            Rp. {{ ($details['price'] - ($details['price'] * $details['disc']/100)) * $details['quantity'] }}
                        @endif    
                    </td>
                    
                    <td class="actions" data-th="">
                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                    </td>

                </tr>

            @endforeach
            
            @endif
            </tbody>
            <tfoot>
                <tr class="visible-xs">
                    <td colspan="" class="text-center"><strong>Total {{ $total }}</strong></td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-warning">Check Out<i class="fa fa-angle-right"></i>
                    </td>
                    <td colspan="2" class="hidden-xs">
                        
                    </td>
                    <td class="hidden-xs text-center"><strong>
                        Total Rp. {{ $total }}</strong>
                    </td>
                </tr>
                @method('POST')
                @csrf
               </form>
            </tfoot>
        </table>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        
        $(".update-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection