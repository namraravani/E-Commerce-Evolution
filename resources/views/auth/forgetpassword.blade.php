<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="card-header">Reset Password</div>
    <div class="card-body">

      @if (Session::has('message'))
           <div class="alert alert-success" role="alert">
              {{ Session::get('message') }}
          </div>
      @endif

        <form action="{{ route('forget.password.post') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                <div class="col-md-6">
                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Send Password Reset Link
                </button>
            </div>
        </form>

    </div>
</div>
</body>
</html>
