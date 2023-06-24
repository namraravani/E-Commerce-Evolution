@extends('product.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('product.create') }}"> Create New Product</a>
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

                    <table id="zero_configuration_table" class="table table-hover" style=width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>code</th>
                                <th>Thumbnail</th>
                                <th>price</th>
                                <th>Description</th>
                                <th>Stock Quantity </th>
                                <th>Status </th>
                                <th>category Name </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
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
                    "url": "{{ route('product.getProduct') }}",
                    "type": "POST",
                    "data": function(data) {
                        data._token = $('meta[name="csrf-token"]').attr('content');

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
