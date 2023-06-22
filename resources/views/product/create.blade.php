@extends('product.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('product.index') }}">Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="form-bordered">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" name="brand" class="form-control" id="brand" placeholder="Enter Brand">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" name="code" class="form-control" id="code" placeholder="Enter Code">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="image">Thumbnail:</label>
                <input type="file" name="image" class="form-control-file" id="image" accept="image/">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="image">images:</label>
                <input type="file" name="images[]" class="form-control-file" id="images" accept="image/" multiple>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" name="description" class="form-control" id="description" placeholder="Enter Description">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="text" name="stock_quantity" class="form-control" id="stock_quantity" placeholder="Enter Quantity">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="status">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="active" value="1" checked>
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                    <label class="form-check-label" for="inactive">Inactive</label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="category_id">Category Name:</label>
                <select name="category_id" id="category-dropdown" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                     @endforeach
                </select>
            </div>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
