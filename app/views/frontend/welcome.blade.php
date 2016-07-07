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
                            <p class="pull-left"
                               style="border:1px solid rgba(0,0,0,0.2);padding:5px;background-color: #f5f5f5">
                                <b>$ {{ $product->price }}</b>
                            </p>

                            {{ Form::open (array('url' => url('product'))) }}


                                <input type="hidden" name="quantity" value="1" >

                                <input type="hidden" name="price" value="200">

                                <input type="hidden" name="productname" value="Car">

                                <input type="hidden" name="description" value="Hello This is the description">

                                <button style="padding:5px;border-radius: 0;" class="btn btn-warning pull-right" type="submit">Send To Ebay</button>

                            {{Form::close()}}

                            <a href="{{ route('carts.show',$product->id) }}">
                                <Button style="padding:5px;border-radius: 0;" class="btn btn-warning pull-right">Add To
                                    Cart <i class="ion ion-ios-cart-outline"></i></Button>
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection