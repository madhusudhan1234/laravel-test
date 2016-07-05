@extends('frontend.layouts.master')

@section('title','Welcome To You')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($products as $product)

            <div class="col-lg-4 boxes">
                <div class="box">
                    <img src="assets/images/{{ $product->image }}" alt="" class="img-responsive">
                    <h4>{{ $product->title }}</h4>
                    <p>{{ $product->description }}</p>
                    <div class="price-buy">
                        <p class="pull-left">Price :{{ $product->price }} Rs</p>

                        {{ Form::open (array('url' => url('payment'))) }}

                            <input type="hidden" name="id" value="1">

                            <input type="hidden" name="product_id" value="1" >

                            <input type="hidden" name="price" value="200">

                            <input type="hidden" name="quantity" value="2">

                            <input type="hidden" name="total" value="400">

                            <input type="hidden" name="status" value="1">

                            {{ Form::submit('Buy This',['class'=>'btn btn-primary pull-right']) }}

                        {{Form::close()}}
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
@endsection