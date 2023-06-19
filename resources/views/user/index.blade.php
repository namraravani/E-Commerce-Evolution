@extends('user.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>user</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('user.create') }}"> Create New user</a>
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

                    <table id="zero_configuration_table" class="table table-hover" style=width:100%>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
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
                    "url": "{{ route('user.getUser') }}",
                    "type": "POST",
                    "data": function(data) {
                        data._token = $('meta[name="csrf-token"]').attr('content');

                    },

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
