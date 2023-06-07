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

    <form action="{{ route('category.index') }}" method="GET">

        <div class="form-group">
            <input type="text" name="search" id="" class="form-control" placeholder="Search by name" value="{{$search}}">
            <button class="btn btn-primary">Search</button>
        <a href="{{url('/admin/dashboard/category')}}">
            <button class="btn btn-primary">Reset</button>
        </a>
        </div>

    </form>

    <table class="table" id="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Status</th>
            <th width="200px">Action</th>
        </tr>
        </thead>

            <tbody>
                @foreach($categories as $category)
                <tr class="category{{$category->id}}">
                    <td>{{++$i}}</td>
                    <td><img src="/{{$category->image}}" width="100px"></td>
                    <td>{{$category->name}}</td>
                    <td>{{ $category->status == 1 ? 'Active' : 'InActive' }}</td>

                    <td>
                        <form action="{{ route('category.destroy',$category->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('category.show',$category->id) }}"><i class="fa-solid fa-eye"></i> </a>

                            <a class="btn btn-primary" href="{{ route('category.edit',$category->id) }}"><i class="fa-solid fa-pen"></i></a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>





    </table>
    {{$categories->links()}}


@endsection
