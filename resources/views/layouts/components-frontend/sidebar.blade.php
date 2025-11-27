<!-- ===== SIDEBAR START (NEW) ===== -->

<style>
    /* Tinggi navbar agar sidebar mulai setelahnya */
    .navbar-height {
        height: 70px !important;
    }

    .sidebar {
        width: 260px;
        height: calc(100vh - 70px); /* mulai setelah navbar */
        position: fixed;
        left: 0;
        top: 70px; /* geser ke bawah agar menyatu */
        background: #ffffff;
        border-right: 1px solid #e5e5e5;
        padding: 20px 15px 0 15px;
        transition: all .3s ease;
        z-index: 9998;
    }

    .sidebar-inner {
        height: calc(100vh - 120px);
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* COLLAPSED MODE */
    .sidebar.collapsed {
        width: 80px;
    }
    .sidebar.collapsed .logo h5,
    .sidebar.collapsed .sidebar-menu span {
        display: none !important;
    }

    /* MENU */
    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        margin-bottom: 8px;
        border-radius: 10px;
        color: #333;
        font-weight: 600;
        transition: .2s;
        text-decoration: none;
        white-space: nowrap;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
        background: #EBF4FF;
        color: #0052CC;
    }

    .sidebar-menu i {
        font-size: 20px;
    }

    /* MOBILE */
    @media(max-width: 992px) {
        .sidebar {
            left: -260px;
        }
        .sidebar.show {
            left: 0;
        }
    }
</style>

<div class="sidebar" id="sidebar">

    <div class="sidebar-inner">
        <div class="sidebar-menu">

            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <i class="lni lni-home"></i> <span>Home</span>
            </a>


            @auth
                <hr>

                <a href="{{ route('tiket.index') }}" class="{{ request()->routeIs('tiket.*') ? 'active' : '' }}">
                    <i class="lni lni-ticket"></i> <span>Tiket Saya</span>
                </a>

                <a href="{{ route('report.index') }}" class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                    <i class="lni lni-files"></i> <span>Laporan</span>
                </a>

                <a href="{{ route('notifications.index') }}">
                    <i class="lni lni-alarm"></i> <span>Notifikasi</span>
                </a>

                <hr>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="lni lni-exit"></i> <span>Logout</span>
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
            @endauth

            @guest
                <hr>
                <a href="{{ route('login') }}"><i class="lni lni-enter"></i> <span>Login</span></a>
                <a href="{{ route('register') }}"><i class="lni lni-user"></i> <span>Register</span></a>
            @endguest

        </div>
    </div>
</div>

<script>
    // Toggle sidebar digabung dengan toggle di NAVBAR
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("collapsed");
        sidebar.classList.toggle("show");
    }
</script>

<!-- ===== SIDEBAR END (NEW) ===== -->