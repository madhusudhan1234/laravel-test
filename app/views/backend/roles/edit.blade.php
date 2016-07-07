@extends('backend.layouts.master')

@section('title','Role Create')

@section('content')
    <h1>Edit Role</h1>

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

    {{ Form::model($role, array('method' => 'PATCH', 'route' =>array('roles.update', $role->id))) }}

    <div class="form-group">
        {{ Form::label('role_name', 'Role Name:') }}
        {{ Form::text('role_name',null,['class'=>'form-control']) }}
    </div>

    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection