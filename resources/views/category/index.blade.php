@extends('category.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('category.create') }}"> Create New Category</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-striped-columns" id="mytable">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($category as $category)
        <tr>
            <td>{{ ++$i }}</td>
            <td><img src="/images/{{ $category->image }}" width="100px"></td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->status == 1 ? 'Active' : 'InActive' }}</td>
            <td>
                <form action="{{ route('category.destroy',$category->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('category.show',$category->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('category.edit',$category->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

@endsection
