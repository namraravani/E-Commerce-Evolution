<style>
    .profile-image {
  display: inline-block;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #ffffff;
  color: blue;
  text-align: center;
  font-size: 18px;
  line-height: 40px;
  margin-right: 10px;
  font-weight: bold;
  font-family: 'Arial', sans-serif;
  text-transform: uppercase;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, color 0.3s ease;
}

.profile-image:hover {
  background-color: cyan;
  color: #151212;
}


</style>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand ps-3" href="index.html"><img width="50px" src={{asset('assests/e-com.png')}} alt=""></a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </form>

    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><div class="profile-image">
                <span>{{ substr(session('user'), 0, 1) }}</span>
            </div></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="/dashboard/edit-profile">Edit Profile</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
