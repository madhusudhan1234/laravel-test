@extends('backend.layouts.master')

@section('content')
    <h1>Role Management</h1>
    <p>{{ link_to_route('roles.create', 'Create new Role') }}</p>
    @if ($roles->count())
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Role Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->role_name }}</td>
                    <td>{{ link_to_route('roles.edit', 'Update', array($role->id),
                array('class' => 'btn btn-warning')) }}</td>
                    <td>
                        {{ Form::open(array('method'=> 'DELETE', 'route' =>
                              array('roles.destroy', $role->id))) }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        There are no Roles
    @endif
@endsection