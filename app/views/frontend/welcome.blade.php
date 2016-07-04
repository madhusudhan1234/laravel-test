@extends('frontend.layouts.master')

@section('title','Welcome To You')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4">
                <div class="box">
                    <img src="assets/images/{{ $product->image }}" alt="" class="img-responsive">
                    <h4>{{ $product->title }}</h4>
                    <p>{{ $product->description }}</p>
                    <p>Price :{{ $product->price }} Rs</p>
                    <a href=""><button class="btn btn-primary">Buy This</button></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection