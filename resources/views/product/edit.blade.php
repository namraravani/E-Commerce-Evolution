@extends('product.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit product</h2>

            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
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

    <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Brand:</strong>
                    <input type="text" name="brand" value="{{ $product->brand }}" class="form-control" placeholder="Brand">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Code:</strong>
                    <input type="text" name="code" value="{{ $product->code }}" class="form-control" placeholder="Code">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Thumbnail:</strong>
                    <input type="file" name="image" class="form-control">
                    @if ($product->image)
                        <div class="thumbnail-container">
                            <button type="button" class="btn btn-danger" id="delete_thumbnail_button" onclick="deleteThumbnail()">X</button>
                            <img src="/{{$product->image}}" alt="Product Thumbnail" width="300px" id="thumbnail_image">
                        </div>
                    @else
                        <p>Thumbnail not Found</p>
                    @endif
                </div>
            </div>


            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" name="price" value="{{ $product->price }}" class="form-control" placeholder="price">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <input type="text" name="description" value="{{ $product->description }}" class="form-control" placeholder="description">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Stock Quantity:</strong>
                    <input type="text" name="stock_quantity" value="{{ $product->stock_quantity }}" class="form-control" placeholder="stock_quantity">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1" {{ $product->status == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="inactive" value="0" {{ $product->status == 0 ? 'checked' : '' }}>
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
                            <option value="{{ $data->id }}" {{ $data->id == $product->category_id ? 'selected' : '' }}>
                                {{ $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input hiiden type="checkbox" id="delete_thumbnail" name="delete_thumbnail" value="0">

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <form action="{{ route('product.image.store', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Product Images:</strong>
            @foreach($productImages as $image)
            <form action="{{ route('delete.image', ['image' => $image->id]) }}" method="POST">
                <button class="btn btn-danger">X</button>
                @csrf
                @method('DELETE')
            </form>
            <div class="image-container">
                <img src="{{ asset($image['image']) }}" id="other_image" alt="Product Image" width="200px">
            </div>

            @endforeach
        </div>
    </div>

    <script>
        function deleteThumbnail() {
            const deleteThumbnailCheckbox = document.getElementById('delete_thumbnail');
            deleteThumbnailCheckbox.checked = true;

            const thumbnailContainer = document.querySelector('.thumbnail-container');
            if (thumbnailContainer) {
                thumbnailContainer.remove();
            }
        }
    </script>
    @endsection
    @section('styles')
    <style>
        .thumbnail-container {
            position: relative;
            display: inline-block;
        }

        .thumbnail-container img {
            width: 300px;
        }

        .thumbnail-container button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .image-container {
            position: relative;
            display: inline-block;
        }

        .image-container img {
            width: 300px;
        }

        .image-container button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection




