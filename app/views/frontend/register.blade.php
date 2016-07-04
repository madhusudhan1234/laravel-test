@extends('frontend.layouts.master')

@section('title','User Register')

@section('content')
    <h1>Register</h1>

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

    {{ Form::open(array('route' => 'users.store')) }}

    <div class="form-group">
        {{ Form::label('first_name', 'First Name:') }}
        {{ Form::text('first_name',null,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('last_name', 'Last Name:') }}
        {{ Form::text('last_name',null,['class'=>'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('email', 'Email:') }}
        {{ Form::email('email',null,['class'=>'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('password', 'Password:') }}
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        {{ Form::label('password_confirmation', 'Password Confirmation:') }}
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection