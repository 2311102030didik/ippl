<header class="navbar navbar-dark sticky-top bg-success flex-md-nowrap p-0 shadow-sm">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-4 py-2 fw-bold text-white" href="/">
        <i class="bi bi-leaf me-1"></i> Kebun Kita
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="w-100 d-none d-md-block"></div> <!-- placeholder untuk responsive -->
    <div class="navbar-nav px-3">
        <div class="nav-item text-nowrap">
            <form action="/logout" method="post" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-white px-0 bg-transparent border-0 fw-medium">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>