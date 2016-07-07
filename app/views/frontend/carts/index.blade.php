@extends('frontend.layouts.master')

@section('title','Cart Page')

@section('content')

    <div class="row">

        <table class="table table-hover">

            <tr>
                <th>Product Name</th>
                <th>User Name</th>
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

                <tr>
                    <td>{{ Product::find($cart->product_id)->title }}</td>
                    <td>{{ User::find($cart->user_id)->first_name }}</td>
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

        <br/><br/>
        <a href="{{ URL::to('logout') }}">
            <button class="btn btn-primary">Logout {{ Auth::user()->first_name.' '.Auth::user()->last_name  }} </button>
        </a>

    </div>
@endsection