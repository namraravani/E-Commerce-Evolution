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
        <title>Login - SB Admin</title>
        <link href={{ asset('assests/css/styles.css') }} rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.j"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css" rel="stylesheet">
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form id="myform" method="POST">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputemail" type="email" placeholder="name@example.com" />
                                                <span class="email_err text-danger"></span>

                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputpassword" type="password" placeholder="Password" />
                                                <span class="password_err text-danger"></span>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="#l">Forgot Password?</a>
                                                <button class="btn btn-primary"  type="button" onclick="loginuser()">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="/admin/register">Need an account? Sign up!</a></div>
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
            function loginuser()
                {


                    var _token = $("input[name='_token']").val();
                    var email = $("#inputemail").val();
                    var password = $("#inputpassword").val();

                    $.ajax({
                        url:"{{ route('validateform') }}",
                        type:"POST",
                        data:{_token:_token,email:email,password:password},
                        success:function(data){
                            console.log(data);
                            if($.isEmptyObject(data.error)){
                                if((data.success)){
                                $('.email_err').text('');
                                $('.password_err').text('');
                                window.location.href = '/admin/dashboard';
                                }
                                else if(alert(data.failed))
                                {
                                    $('.email_err').text('');
                                    $('.password_err').text('');
                                    window.location.href = '/admin/dashboard';
                                }

                            }
                            else{
                                printerrormsg(data.error);

                            }
                        }


                    });


                }

                function printerrormsg(msg){
                    $.each(msg,function(key,value){
                        console.log(key);
                        $('.'+key+'_err').text(value);
                    })

                }



        </script>
    </body>
</html>
