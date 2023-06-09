@extends('customer.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New customer</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('customer.index') }}">Back</a>
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

<form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" id="image" accept="image/">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>first_name:</strong>
                <input type="text" name="first_name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>last_name:</strong>
                <input type="text" name="last_name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>email:</strong>
                <input type="text" name="email" class="form-control" placeholder="email">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>MobileNo:</strong>
                <input type="number" name="mobileno" class="form-control" placeholder="mobileno">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>address:</strong>
                <input type="text" name="address" class="form-control" placeholder="address">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>Country</strong>
                <select name="country" id="country-dropdown" class="form-control">
                    <option value="">Select Country</option>
                    @foreach($countries as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>State</strong>
                <select name="state" id="state-dropdown" class="form-control">


                </select>
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>City</strong>
                <select name="city" id="city-dropdown" class="form-control">
                </select>
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>PinCode</strong>
                <input type="number" name="pincode" class="form-control" placeholder="number">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#country-dropdown').on('change', function() {
                var country_id = this.value;
                console.log(country_id);
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{ route('fetchstate') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html('<option value="">-- Select State --</option>');
                        $.each(result.states,function(key, value) {
                            $("#state-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html('<option value="">-- Select cityt --</option>');

                    }
                });
            });

            $('#state-dropdown').on('change', function() {
                var idState = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ route('fetchcity') }}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</form>
@endsection
