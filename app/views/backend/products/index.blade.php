@extends('backend.layouts.master')

@section('content')
    <h1>Welcome to This Website</h1>
    <p>{{ link_to_route('products.create', 'Create new Product') }}</p>
    @if ($products->count())
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Published By</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->user_id }}</td>
                    <td><img src="assets/images/{{ $product->image }}" alt="" height="50px" width="50px"></td>
                    <img src="">
                    <td>{{ link_to_route('products.edit', 'Update', array($product->id),
                array('class' => 'btn btn-warning')) }}</td>
                    <td>
                        {{ Form::open(array('method'=> 'DELETE', 'route' =>
                              array('products.destroy', $product->id))) }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        There are no Products
    @endif
@endsection