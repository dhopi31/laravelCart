@extends('layouts.app')
@section('title' , 'CART LIVE')
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
            <?php  $j = count(session('cart')) ?>
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
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                                <img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/>
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>

                    <td data-th="Price">
                        @if ($details['disc']==0)
                            Rp. {{ $details['price'] }}
                            <input type="hidden"   id="price{{$loop->iteration}}" value="{{ $details['price'] }}" class="form-control quantity"  />
                        @else
                            <input type="hidden"   id="price{{$loop->iteration}}" value="{{ $details['price'] - ($details['price'] * $details['disc']/100) }}" class="form-control quantity"  />
                            Rp. {{ $details['price'] - ($details['price'] * $details['disc']/100) }}
                        @endif
                    </td>

                    <td data-th="Quantity">
                        <input type="hidden"   id="j" value="{{ $j }}"> 
                        <input type="number"   class="qty form-control"  name="qty[]" id="qty{{$loop->iteration}}"   value="{{ $details['quantity'] }}" class="form-control quantity" min='1' />
                    </td>

                    <td data-th="Subtotal" class="text-center">
                        @if ($details['disc']==0)
                            <input type="text" class="qty form-control" readonly  id="tot{{$loop->iteration}}"   value="{{ $details['price'] * $details['quantity'] }}"> 
                        @else
                            <input type="text" class="qty form-control" readonly  id="tot{{$loop->iteration}}"   value="{{ ($details['price'] - ($details['price'] * $details['disc']/100)) * $details['quantity'] }}">  
                        @endif
                    </td>

                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>

                </tr>
            @endforeach
            @endif
            </tbody>
            <tfoot>
                <tr class="visible-xs">
                    <td colspan="3">
                    </td>
                    <td colspan="2" class="text-center">
                        <strong>
                            Total 
                        </strong>
                        <input readonly class="form-control" name="total" type="text" id="total_all"  value="{{ $total }}"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <button type="submit" class="btn btn-warning"> Check Out <i class="fa fa-angle-right"></i>
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
        $(document).ready(function() {
       
            var j  = $("#j").val();
            var sub_total_list=0;

            $(".qty").on('change',function() {
                var sub_total = 0;
                var total = 0;
                for (let i = 1; i <= j; i++) {
                    var harga  = $("#price"+i).val();
                    var jumlah = $("#qty"+i).val();
                    sub_total = parseInt(harga) * parseInt(jumlah);
                    $("#tot"+i).val(sub_total);
                    total +=parseInt(sub_total);
                }
            $("#total_all").val(total);
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