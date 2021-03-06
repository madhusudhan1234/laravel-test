@extends('backend.layouts.master')

@section('title','Product Create')

@section('content')
    <h1>Create Product</h1>

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

    {{ Form::open(array('route' => 'products.store','files'=>'true')) }}

    <div class="form-group">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title',null,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('price', 'Price:') }}
        {{ Form::text('price',null,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description:') }}
        {{ Form::textarea('description',null,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        <label for="image"> Upload Image</label>
        <input type="file" name="image">
    </div>

    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection