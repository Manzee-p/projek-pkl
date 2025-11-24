<nav class="navbar navbar-expand-lg bg-light shadow-sm py-2 px-4 
     d-flex justify-content-between align-items-center fixed-top">

    <!-- LEFT: Toggle -->
    <div class="d-flex align-items-center">
        <button onclick="toggleSidebar()" class="btn btn-outline-primary me-3">
    <i class="lni lni-menu"></i>
</button>

    </div>

    <!-- CENTER: Search Bar (LEBIH BESAR) -->
    <div class="flex-grow-1 d-flex justify-content-center">
        <form class="search-wrapper w-100" style="max-width: 780px;">  <!-- <<< ukuran search bar -->
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="lni lni-search-alt"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search...">
            </div>
        </form>
    </div>

    <!-- RIGHT: Notif + Profile -->
    <!-- RIGHT: Notif + Profile -->
<!-- RIGHT: Notif + Profile -->
<div class="d-flex align-items-center gap-3" style="margin-right: 20px;">
    @auth
    <!-- Notification Bell -->
    <div class="dropdown">
        <a href="#" class="position-relative text-decoration-none" 
           id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="lni lni-alarm" style="font-size: 24px; color: #0052CC;"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                  id="notif-badge" style="display: none; font-size: 10px;">
                0
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg notification-dropdown" 
            aria-labelledby="notificationDropdown" 
            style="width: 380px; max-height: 500px;">
            <li class="dropdown-header d-flex justify-content-between align-items-center border-bottom p-3">
                <span class="fw-bold">Notifikasi</span>
                <a href="#" id="mark-all-read" class="text-primary small text-decoration-none">
                    Tandai semua dibaca
                </a>
            </li>
            <div id="notification-list" style="max-height: 400px; overflow-y: auto;">
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <li class="dropdown-footer text-center p-2 border-top">
                <a href="{{ route('notifications.index') }}" class="text-primary small text-decoration-none">
                    Lihat Semua Notifikasi
                </a>
            </li>
        </ul>
    </div>

    <!-- Profile Dropdown -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/images/faces/pp.jpg') }}" alt="Profile" width="40"
                height="40" class="rounded-circle me-2" />
            <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
            <li>
                <a class="dropdown-item" href="#">
                    <i class="mdi mdi-account-circle text-primary me-2"></i>Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="mdi mdi-settings text-primary me-2"></i>Settings
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout me-2"></i>Logout
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    @else
    <!-- Tombol Login/Register jika belum login -->
    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Login</a>
    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4">Register</a>
    @endauth
</div>


</nav>

<style>
     .body {
    padding-top: 70px !important;
}

    #sidebarToggle {
        border-radius: 8px;
    }
    .input-group-text {
        border-radius: 8px 0 0 8px !important;
    }
    .form-control {
        border-radius: 0 8px 8px 0 !important;
    }

    /* tengah */
    .nav .search-wrapper {
        margin-left: auto;
        margin-right: auto;
    }
    .navbar {
    height: 70px !important;
}

</style>
