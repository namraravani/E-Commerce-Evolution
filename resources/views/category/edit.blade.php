@extends('category.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit category</h2>

            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('category.index') }}"> Back</a>
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

    <form action="{{ route('category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="inactive" value="0" {{ $category->status == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Thumbnail:</strong>
                    <input type="file" name="image" class="form-control">
                    @if ($category->image)
                        <div class="thumbnail-container">
                            <button type="button" class="btn btn-danger" id="delete_thumbnail_button" onclick="deleteThumbnail()">X</button>
                            <img src="/{{$category->image}}" alt="Product Thumbnail" width="300px" id="thumbnail_image">
                        </div>
                    @else
                        <p>Thumbnail not Found</p>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

        <input hidden type="checkbox" id="delete_thumbnail" name="delete_thumbnail" value="0">

    </form>

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
