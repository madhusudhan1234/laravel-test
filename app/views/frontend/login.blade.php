@extends('frontend.layouts.master')

@section('title','Login Page')

@section('content')

    {{ Form::open(array('url'=>'users/login', 'class'=>'form-signin')) }}

    <h2 class="form-signin-heading">Please Login</h2>
    <hr>

        <div class="form-group">
            {{ Form::label('email','Email:') }}
            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
        </div>

        <div class="form-group">
            {{ Form::label('password','Password:') }}
            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
        </div>

        {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}

    {{ Form::close() }}
@endsection