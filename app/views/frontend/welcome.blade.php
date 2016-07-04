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
                        <a href=""><button class="btn btn-primary pull-right">Buy This</button></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection