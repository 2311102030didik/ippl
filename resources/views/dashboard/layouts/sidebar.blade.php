<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="sidebar-header text-center mb-4">
            <h6 class="text-light fw-semibold">Admin Kebun Kita</h6>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page"
                    href="/dashboard">
                    <span data-feather="home"></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ Request::is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
                    <span data-feather="file-text"></span>
                    <span class="menu-text">My Post</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
  /* 🌿 Sidebar Styling */
  #sidebarMenu {
    background-color: #6ab96a; /* warna hijau seperti gambar */
    min-height: 100vh;
    border-right: none;
    color: #fff;
    padding-top: 1rem;
  }

  /* Header text */
  .sidebar-header h6 {
    color: #fff;
    font-weight: 600;
  }

  /* Link dasar */
  #sidebarMenu .nav-link {
    color: #ffdf80; /* kuning lembut seperti di gambar */
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.2s ease, color 0.2s ease;
    padding: 0.6rem 1rem;
  }

  /* Link saat di-hover */
  #sidebarMenu .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  /* Link aktif */
  #sidebarMenu .nav-link.active {
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
    border-radius: 5px;
  }

  /* Feather icons warna hitam seperti gambar */
  #sidebarMenu [data-feather] {
    color: #1e1e1e;
    stroke-width: 2px;
  }

  /* Menu text */
  .menu-text {
    font-size: 15px;
  }

  /* Hilangkan background putih default Bootstrap */
  .bg-light {
    background-color: transparent !important;
  }
</style>
