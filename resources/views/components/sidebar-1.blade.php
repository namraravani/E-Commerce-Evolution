

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/admin/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="/admin/dashboard/category">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-c"></i></div>
                    category

                </a>

                <a class="nav-link collapsed" href="/admin/dashboard/product">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Product
                </a>


                <a class="nav-link" href="/admin/dashboard/user">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-plus"></i></div>
                    Users
                </a>
                <a class="nav-link" href="/admin/dashboard/customer">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-person"></i></div>
                    Customers
                </a>

                <a class="nav-link" href="/admin/dashboard/role">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-address-book"></i></div>
                    Roles
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{session('user')}}
        </div>
    </nav>
</div>

