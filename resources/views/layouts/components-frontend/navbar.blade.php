<!-- ========================= header-6 start ========================= -->
<header class="header header-6 py-2 shadow-sm bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg align-items-center">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="Logo" height="50" class="me-2 rounded" />
                <h5 class="mb-0 fw-bold text-primary"></h5>
            </a>

            {{-- Toggle button for mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar content --}}
            <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item mx-2">
                        <a class="nav-link active text-primary fw-semibold" href="#home">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#feature">Feature</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#about">About</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#contact">Contact</a>
                    </li>
                    
                    {{-- Menu untuk user yang sudah login --}}
                    @auth
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold {{ request()->routeIs('tiket.*') ? 'text-primary' : 'text-dark' }}"
                            href="{{ route('tiket.index') }}" 
                            style="display: flex; align-items: center; gap: 5px;">
                            <i class="lni lni-ticket"></i> Tiket Saya
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold {{ request()->routeIs('report.*') ? 'text-primary' : 'text-dark' }}"
                            href="{{ route('report.index') }}" 
                            style="display: flex; align-items: center; gap: 5px;">
                            <i class="lni lni-files"></i> Laporan
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            {{-- Right section: actions + profile --}}
            <div class="d-flex align-items-center gap-3">
                @auth
                    {{-- Notification Bell --}}
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
                                <!-- Notifikasi akan dimuat di sini -->
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

                    {{-- Profile Dropdown --}}
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
                    {{-- Tombol Login/Register jika belum login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4">Register</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
<!-- ========================= header-6 end ========================= -->

<style>
.header-action .dropdown-menu {
    min-width: 200px;
    border-radius: 12px;
    padding: 10px;
    margin-top: 10px;
}

.header-action .dropdown-item {
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s;
}

.header-action .dropdown-item:hover {
    background: #EBF4FF;
    color: #0052CC;
}

.header-action .dropdown-item i {
    margin-right: 8px;
    width: 20px;
}

.navbar-nav .nav-link.text-primary {
    font-weight: 600;
}

/* Notification Styles */
.notification-dropdown {
    border-radius: 12px;
    border: 1px solid #e0e0e0;
}

.notification-dropdown .dropdown-item {
    white-space: normal;
    padding: 12px 16px;
    border-bottom: 1px solid #f5f5f5;
    transition: all 0.3s;
    cursor: pointer;
}

.notification-dropdown .dropdown-item:last-child {
    border-bottom: none;
}

.notification-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
}

.notification-dropdown .dropdown-item.unread {
    background-color: #e3f2fd;
    border-left: 3px solid #2196F3;
}

.notification-item {
    display: flex;
    align-items: start;
    gap: 12px;
}

.notification-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
}

.notification-icon.status-update {
    background-color: #e8f5e9;
    color: #4CAF50;
}

.notification-icon.reply {
    background-color: #fff3e0;
    color: #FF9800;
}

.notification-icon.closed {
    background-color: #f3e5f5;
    color: #9C27B0;
}

.notification-content {
    flex: 1;
}

.notification-content h6 {
    font-size: 13px;
    margin-bottom: 4px;
    font-weight: 600;
    color: #333;
}

.notification-content p {
    font-size: 12px;
    color: #666;
    margin-bottom: 4px;
}

.notification-time {
    font-size: 11px;
    color: #999;
}

.dropdown-header {
    background-color: #f8f9fa;
    font-size: 14px;
}

.dropdown-footer {
    background-color: #f8f9fa;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Fungsi untuk memuat notifikasi
    function loadNotifications() {
        $.ajax({
            url: '{{ route("notifications.unread") }}',
            method: 'GET',
            success: function(response) {
                updateNotificationUI(response);
            },
            error: function(xhr) {
                console.error('Error loading notifications:', xhr);
            }
        });
    }

    // Update UI notifikasi
    function updateNotificationUI(data) {
        const badge = $('#notif-badge');
        const list = $('#notification-list');

        // Update badge
        if (data.unread_count > 0) {
            badge.text(data.unread_count).show();
        } else {
            badge.hide();
        }

        // Update list
        if (data.notifications.length === 0) {
            list.html(`
                <div class="text-center py-5">
                    <i class="lni lni-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-2 mb-0">Tidak ada notifikasi baru</p>
                </div>
            `);
        } else {
            let html = '';
            data.notifications.forEach(function(notif) {
                const isUnread = !notif.status_baca;
                let iconClass = 'status-update';
                let icon = 'lni-refresh';
                
                if (notif.pesan.includes('diubah')) {
                    iconClass = 'status-update';
                    icon = 'lni-reload';
                } else if (notif.pesan.includes('membalas')) {
                    iconClass = 'reply';
                    icon = 'lni-reply';
                } else if (notif.pesan.includes('ditutup') || notif.pesan.includes('closed')) {
                    iconClass = 'closed';
                    icon = 'lni-close';
                }
                
                html += `
                    <li>
                        <a class="dropdown-item ${isUnread ? 'unread' : ''}" 
                           href="#" 
                           data-notif-id="${notif.notif_id}"
                           data-tiket-id="${notif.tiket_id}">
                            <div class="notification-item">
                                <div class="notification-icon ${iconClass}">
                                    <i class="${icon}"></i>
                                </div>
                                <div class="notification-content">
                                    <h6>${notif.pesan.substring(0, 70)}${notif.pesan.length > 70 ? '...' : ''}</h6>
                                    <p class="notification-time">${formatTime(notif.waktu_kirim)}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                `;
            });
            list.html(html);
        }
    }

    // Format waktu relatif
    function formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // dalam detik

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
        if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
        
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
    }

    // Handle klik notifikasi
    $(document).on('click', '[data-notif-id]', function(e) {
        e.preventDefault();
        const notifId = $(this).data('notif-id');
        const tiketId = $(this).data('tiket-id');

        // Tandai sebagai sudah dibaca
        $.ajax({
            url: `/notifications/${notifId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                // Redirect ke halaman tiket
                window.location.href = `/tiket/${tiketId}`;
            }
        });
    });

    // Tandai semua sebagai sudah dibaca
    $('#mark-all-read').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("notifications.readAll") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                loadNotifications();
            }
        });
    });

    // Load notifikasi saat halaman dimuat
    loadNotifications();

    // Auto refresh setiap 30 detik
    setInterval(loadNotifications, 30000);

    // Refresh saat dropdown dibuka
    $('#notificationDropdown').on('click', function() {
        loadNotifications();
    });
});
</script>