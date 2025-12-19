<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-4">
        <div class="sidebar-header text-center mb-4">
            <div class="bg-white rounded-circle mx-auto mb-2 p-2" style="width: 60px; height: 60px;">
                <i class="bi bi-shield-check text-success" style="font-size: 28px;"></i>
            </div>
            <h6 class="text-white fw-bold">Admin Kebun Kita</h6>
        </div>
        <ul class="nav flex-column px-3">
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                    <i class="bi bi-house-door me-2"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center {{ Request::is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span class="menu-text">My Post</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
  #sidebarMenu {
    background: linear-gradient(to bottom, #5a9e5a, #4a7c4a); /* hijau alami, lebih dinamis */
    min-height: 100vh;
    color: #fff;
  }

  .sidebar-header h6 {
    color: #fff;
    font-size: 15px;
  }

  #sidebarMenu .nav-link {
    color: #e0f0d9;
    font-weight: 500;
    padding: 0.65rem 1rem;
    border-radius: 6px;
    margin-bottom: 4px;
    transition: all 0.2s ease;
  }

  #sidebarMenu .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.12);
    color: #fff;
  }

  #sidebarMenu .nav-link.active {
    background-color: rgba(0, 0, 0, 0.15);
    color: #fff;
  }

  #sidebarMenu .nav-link i {
    width: 20px;
    text-align: center;
  }
</style>
