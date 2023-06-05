@if(session('user')!=NULL)
{
    <script>window.location.href = '/admin/dashboard'</script>
}
@endif
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href={{ asset('/assests/css/styles.css') }} rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form id="#myform" method="POST">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="firstname" type="text" placeholder="Enter your first name" />
                                                        <span class="first_name_err"></span>
                                                        <label for="inputFirstName">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="lastname" type="text" placeholder="Enter your last name" />
                                                        <span class="last_name_err"></span>
                                                        <label for="inputLastName">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputemail" type="email" placeholder="name@example.com" />
                                                <span class="email_err"></span>
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputpassword" type="password" placeholder="Create a password" />
                                                        <span class="register_password_err"></span>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputcpassword" type="password" placeholder="Confirm password" />
                                                        <span class="c_password_err"></span>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary" type="button" onclick="registeruser()">Create Account</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="/admin/login">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>


                function registeruser() {
                    

                    var _token = $("input[name='_token']").val();
                    var first_name = $("#firstname").val();
                    var last_name = $("#lastname").val();
                    var register_email = $("#inputemail").val();
                    var register_password = $("#inputpassword").val();
                    var c_password = $("#inputcpassword").val();

                    $.ajax({
                        url:"{{ route('validateform_register') }}",
                        type:"POST",
                        data:{_token:_token,first_name:first_name,last_name:last_name,register_email:register_email,register_password:register_password,c_password:c_password},
                        success:function(data){
                            console.log(data);
                            if($.isEmptyObject(data.error)){
                                alert(data.success);
                                $('.first_name_err').text('');
                                $('.last_name_err').text('');
                                $('.register_email_err').text('');
                                $('.register_password_err').text('');
                                $('.c_password_err').text('');

                                window.location.href = "/admin/login";

                            }
                            else{
                                printerrormsg(data.error);

                            }
                        }
                        cache: false,
                        contentType: false,
                        processData: false
                    });


                }


                function printerrormsg(msg){
                    $.each(msg,function(key,value){
                        console.log(key);
                        $('.'+key+'_err').text(value);
                    })

                }
            // });


        </script>
        <script>

        </script>
    </body>
</html>
