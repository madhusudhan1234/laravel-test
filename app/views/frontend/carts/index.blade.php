@extends('frontend.layouts.master')

@section('title','Cart Page')

@section('content')

    <div class="row">

        <table class="table table-hover">

            <tr>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Total</th>
                <th>Checkout</th>
            </tr>

            @foreach($carts as $cart)

                {{ Form::open (array('url' => url('payment'))) }}

                    {{ Form::hidden('id', $cart->id) }}
                    {{ Form::hidden('product_id', $cart->product_id) }}
                    {{ Form::hidden('price', $cart->price) }}
                    {{ Form::hidden('quantity', $cart->quantity) }}
                    {{ Form::hidden('total', $cart->total) }}
                    {{ Form::hidden('status', $cart->status) }}

                     {{--<input type="hidden" name="id" value="1">

                    <input type="hidden" name="product_id" value="1">--}}

                    {{--<input type="hidden" name="price" value="200">--}}

                    {{--<input type="hidden" name="quantity" value="2">--}}

                    {{--<input type="hidden" name="total" value="400">--}}

                    {{--<input type="hidden" name="status" value="1">--}}

                    <tr>
                        <td>{{ $cart->price }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>{{ $cart->status }}</td>
                        <td>{{ $cart->total }}</td>
                        <td>
                            {{ Form::submit('CheckOut',['class'=>'btn btn-warning']) }}
                        </td>
                        {{Form::close()}}
                        <td>
                    </tr>
            @endforeach

        </table>
    </div>
@endsection