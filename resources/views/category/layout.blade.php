@extends('dashboard')
@section('category-content')
<!DOCTYPE html>
<html>
<head>
    <title>Category</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{--     <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
{{--     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"> --}}
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
{{--     <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> --}}
{{--     <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> --}}
<script src="https://kit.fontawesome.com/d98a6653af.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>

<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href={{ asset('assests/css/create_category.css')}} class="css">

{{-- <script>
    function fetch(std,res){
        $.ajax({
            url: "{{route('category/records')}}",
            type: "GET",
            data:{
                std: std,
                res: res
            },
            dataType: "json",

success: function(data) {
    var i = 1;
    $('#table').DataTable({
        "data": data.students,
        "responsive": true,
        "columns": [
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return i++;
                }
            },
            {
                "data": "img",
                "render": function(data, type, row, meta) {
                    return '<img src="' + data + '" alt="Image">';
                }
            },
            {
                "data": "img",
                "render": function(data, type, row, meta) {
                    return row.standard + "th standard";
                }
            },
            {
                "data": "name"
            },
            {
                "data": "name",
                "render": function(data, type, row, meta) {
                    return row.name;
                }
            },
            {
                "data": "status"
            },
            {
                "data": "status",
                "render": function(data, type, row, meta) {
                    return row.status;
                }
            }
        ]
    });
}
// ...

        });
    }
</script> --}}


</head>
<body>

<div class="container">
    @yield('content')
</div>
@endsection

</body>
</html>
