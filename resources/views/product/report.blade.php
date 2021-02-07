@extends('layouts.app')
@section('title' , 'PRODUCT')
@section('content')
<div class="container products">
    <div class="row ">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Transaction Code</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Item</th>
                </tr>
            </thead>
            @foreach($detail as $key=>$list_report)
            <tbody>
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <th scope="row">{{ $list_report->trans_code }}</th>
                <td>{{ ucfirst($list_report->user_name[0]['name']) }}</td>
                <td>{{ $list_report->total }}</td>
                <td>
                    @foreach($list_report->transaction_detail as $item)
                        <li>{{ $item->quantity }}</li>
                    @endforeach
                </td>
                <td>
                    @foreach($list_report->transaction_detail as $item)
                        <li>{{ $item->item_name->name }}</li>
                    @endforeach
                </td>
            </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
  @endsection