@extends('backend.layouts.master')

@section('content')
    <h1>Welcome to This Website</h1>
    <p>{{ link_to_route('users.create', 'Create new User') }}</p>
    @if ($users->count())
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ Role::find($user->role_id)->role_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ link_to_route('users.edit', 'Update', array($user->id),
                array('class' => 'btn btn-warning')) }}</td>
                    <td>
                        {{ Form::open(array('method'=> 'DELETE', 'route' =>
                              array('users.destroy', $user->id))) }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        There are no Users
    @endif
@endsection