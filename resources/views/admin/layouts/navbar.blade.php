<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/admin/dashboard"><strong class="text-danger">HK</strong> DECORATION</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <div class="ms-auto">
    </div>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item">{{auth()->user()->username}}</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="astext w-100 text-start">
                        <li>
                            <a class="dropdown-item">Logout</a>
                        </li>
                    </button>
                </form>
            </ul>
        </li>
    </ul>
</nav>