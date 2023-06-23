@extends('dashboard')
@section('product-content')
<!DOCTYPE html>
<html>
<head>
    <title>Category</title>

<meta content="{{ csrf_token() }}" name="csrf-token">
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@yield('styles')
<script src="https://kit.fontawesome.com/d98a6653af.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
{{-- <link rel="stylesheet" href={{ asset('assests/css/create_product.css')}} class="css"> --}}

</head>
<body>

<div class="container">
    @yield('content')
</div>
@endsection

</body>
</html>
