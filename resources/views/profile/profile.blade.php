@extends('dashboard')
@section('profile-content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit-profile</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('profile/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
	<section class="py-5 my-5">
		<div class="container">
			<h1 class="mb-5">Edit Profile</h1>
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
					<div class="p-4">
						<div class="img-circle text-center mb-3">
							<div class="profile-image">
                                @if (Auth::user()->image)
                                    <div class="profile-image">
                                        <span><img src="/{{ Auth::user()->image }}" width="50px"></span>
                                    </div>
                                @else
                                    <div>{{ substr(Auth::user()->first_name, 0, 1) }}</div>
                                @endif
                            </div>
						</div>
						<h4 class="text-center">{{Auth::user()->first_name}}</h4>
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i>
							Account
						</a>
						<a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i>
							Password
						</a>
					</div>
				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4">Account Settings</h3>
						<form id="editProfileForm" action="{{ route('edit_profile') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group">
									<strong>Image:</strong>
									<input type="file" name="image" class="form-control" placeholder="Image">
									@if (Auth::user()->image)
										<div class="profile-image">
											<span><img src="/{{ Auth::user()->image }}" width="200px"></span>
											<input type="checkbox" class="btn btn-danger" name="delete_image" value="1"> <label>Delete Image</label>
										</div>
									@else
										<div>No Image</div>
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name</label>
										<input type="text" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email</label>
										<input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
									</div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select-role</label>
                                        <select name="role" class="form-control">
                                            @foreach($roles as $role)
                                                <option value="{{$role}}" @if($role == Auth::user()->role) selected @endif>{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
							</div>
							<div>
								<button id="updateButton" class="btn btn-primary" type="submit">Update</button>
								<button class="btn btn-light" type="reset">Cancel</button>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
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
						<h3 class="mb-4">Password Settings</h3>
						<form id="editPasswordForm" action="{{ route('edit_password') }}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Old password</label>
										<input type="password" name="old_password" id="old_password" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>New password</label>
										<input type="password" name="new_password" id="new_password" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Confirm new password</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control">
									</div>
								</div>
							</div>
							<div>
								<button class="btn btn-primary">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		document.addEventListener('submit', function (event) {
			if (event.target.id === 'editProfileForm') {
				event.preventDefault();
				swal("Updated!", "Profile has been successfully updated.", "success");
				event.target.submit();
			}
		});
	});

	document.addEventListener('DOMContentLoaded', function () {
		document.addEventListener('submit', function (event) {
			if (event.target.id === 'editPasswordForm') {
				event.preventDefault();
				swal("Updated!", "Profile has been successfully updated.", "success");
				event.target.submit();
			}
		});
	});
</script>
</html>
