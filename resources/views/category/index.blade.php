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



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="zero_configuration_table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Category Image</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>


    {{-- <table class="table" id="table">
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
    <div>
        Showing {{$categories->firstItem()}} - {{$categories->lastItem()}} of {{$categories->total()}}
    </div>
    {{$categories->links()}} --}}
    <script type="text/javascript">
        $(document).ready(function() {
            dtable = $('#zero_configuration_table').DataTable({
                "language": {
                    "lengthMenu": "_MENU_"
                },
                "columnDefs": [{
                    "targets": "_all",
                    "orderable": false
                }],
                responsive: true,
                'serverSide': true,
                "ajax": {
                    "url": "{{ route('category.getCategory') }}",
                    "type": "POST",
                    "data": function(data) {
                        data._token = $('meta[name="csrf-token"]').attr('content');
                        // Add any additional data parameters as needed
                    },
                    "error": function(xhr, error, thrown) {
                        console.log("Ajax error:", thrown);
                    }
                }
            });

            $('.panel-ctrls').append("<i class='separator'></i>");

            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right");

            $("#apply_filter_btn").click(function() {
                dtable.ajax.reload(null, false);
            });
        });
    </script>


@endsection
