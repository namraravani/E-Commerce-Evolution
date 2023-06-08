@extends('customer.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit customer</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('customer.index') }}"> Back</a>
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

    <form action="{{ route('customer.update',$customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>first_name:</strong>
                    <input type="text" name="first_name" value="{{ $customer->first_name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>last_name:</strong>
                    <input type="text" name="last_name" value="{{ $customer->last_name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>email:</strong>
                    <input type="text" name="email" value="{{ $customer->email }}" class="form-control" placeholder="email">

                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>MobileNo:</strong>
                    <input type="number" name="mobileno" value="{{ $customer->mobileno }}" class="form-control" placeholder="mobileno">

                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>MobileNo:</strong>
                    <input type="text" name="address" value="{{ $customer->address }}" class="form-control" placeholder="address">

                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>Country</strong>
                    <input type="text" name="country" value="{{ $customer->country }}" class="form-control" placeholder="country">
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>State</strong>
                    <input type="text" name="state" value="{{ $customer->state }}" class="form-control" placeholder="state">
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>City</strong>
                    <input type="text" name="city" value="{{ $customer->city }}" class="form-control" placeholder="city">
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="form-group">
                    <strong>Pincode</strong>
                    <input type="number" name="pincode" value="{{ $customer->pincode }}" class="form-control" placeholder="pincode">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

@endsection




