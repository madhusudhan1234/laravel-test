@extends('frontend.layouts.master')

@section('title','Cart Create')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <h4 class="panel-title">Create Cart of {{ $product->title }}</h4>
                </div>

                <div class="panel-body">

                    <div class="col-lg-6">
                        {{ Form::open(array('route'=>'carts.store')) }}

                            <div class="form-group">
                                {{ Form::label('quantity','Quantity') }}
                                {{ Form::text('quantity',null,['class'=>'form-control']) }}
                            </div>

                            {{ Form::hidden('price',$product->price) }}

                            {{ Form::hidden('product_id',$product->id) }}

                            {{ Form::submit('Add To Cart',['class'=>'btn btn-success pull-right']) }}

                        {{ Form::close() }}
                    </div>

                    <div class="col-lg-6">
                        <img src="{{ url('assets/images/'.$product->image) }}" alt="" class="img-responsive">
                        <p class="text-center" style="padding:10px;background-color: #f5f5f5;">
                            <b>$ {{ $product->price }}</b>
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection