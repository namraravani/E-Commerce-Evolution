@if(session('user')==NULL)
{
    <script>window.location.href = '/admin/login'</script>
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
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href={{ asset('assests/css/styles.css')}} rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    @include('components.header')

    <body class="sb-nav-fixed">

        <div id="layoutSidenav">

            <div id="layoutSidenav_nav">
                @include('components.sidebar-1')


            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><span style="color:blue;">Welcome, {{session('user')}} </span></h1>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Admin</li>

                        </ol>
                        @yield('category-content')
                        @yield('user-content')
                        @yield('profile-content')



                    </div>
                </main>
                @include('components.footer')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src={{asset('assests/js/scripts.js')}}></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

    </body>
</html>
