<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Helpdesk</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    
    <!-- LineIcons CDN -->
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --primary-dark: #764ba2;
        }

        body {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .notification-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header Section */
        .notification-hero {
            background: var(--primary-gradient);
            border-radius: 24px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }

        .notification-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .notification-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero-title h3 {
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-title p {
            margin: 0;
            opacity: 0.95;
            font-size: 1rem;
        }

        .btn-mark-all-hero {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-mark-all-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            color: var(--primary-dark);
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.95;
            font-weight: 600;
        }

        /* Alert Success */
        .alert-modern {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: none;
            border-radius: 14px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #065f46;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .alert-modern i {
            font-size: 1.5rem;
        }

        /* Notification Card */
        .notification-card-wrapper {
            background: white;
            border-radius: 20px;
            overflow: visible; /* Changed from hidden to visible */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .notification-item {
            padding: 1.75rem;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .notification-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .notification-item:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            transform: translateX(4px);
        }

        .notification-item:hover::before {
            opacity: 1;
        }

        .notification-item.unread {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-left: 4px solid var(--primary-color);
        }

        .notification-item.unread::before {
            opacity: 1;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notif-icon-box {
            width: 56px;
            height: 56px;
            background: var(--primary-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            position: relative;
        }

        .notif-icon-box.unread::after {
            content: '';
            position: absolute;
            top: -4px;
            right: -4px;
            width: 14px;
            height: 14px;
            background: #ef4444;
            border-radius: 50%;
            border: 3px solid white;
            animation: pulse-indicator 2s infinite;
        }

        @keyframes pulse-indicator {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .badge-new {
            background: var(--primary-gradient);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .notif-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
            line-height: 1.4;
        }

        .notif-message {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        .notif-meta {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #9ca3af;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .meta-item.ticket {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .notif-actions {
            flex-shrink: 0;
            position: relative; /* Added */
            z-index: 100; /* Added */
        }

        .dropdown-toggle-custom {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .dropdown-toggle-custom:hover {
            border-color: var(--primary-color);
            background: #f8f9ff;
            transform: scale(1.05);
        }

        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            padding: 0.5rem;
            z-index: 1050 !important; /* Increased z-index */
            position: absolute !important; /* Force absolute positioning */
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f8f9ff;
            color: var(--primary-color);
        }

        .dropdown-item.text-danger:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Empty State */
        .empty-state-modern {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon-wrapper {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .empty-icon-wrapper i {
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.5;
        }

        .empty-state-modern h5 {
            color: #6b7280;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.35rem;
        }

        .empty-state-modern p {
            color: #9ca3af;
            font-size: 1rem;
            margin: 0;
        }

        /* Pagination */
        .pagination {
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .notification-container {
                padding: 1rem;
            }

            .notification-hero {
                padding: 1.75rem;
                border-radius: 18px;
            }

            .hero-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-title h3 {
                font-size: 1.5rem;
            }

            .btn-mark-all-hero {
                width: 100%;
                justify-content: center;
            }

            .notification-item {
                padding: 1.25rem;
            }

            .notif-icon-box {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            /* FIXED: Dropdown positioning for mobile */
            .notification-card-wrapper {
                overflow: visible !important;
            }

            .dropdown-menu {
                z-index: 9999 !important;
                position: fixed !important;
                right: 1rem !important;
                left: auto !important;
                min-width: 200px;
            }

            .notif-actions {
                margin-left: auto;
                padding-left: 10px;
                position: relative;
                z-index: 100;
            }

            /* Ensure dropdown doesn't get cut off */
            .d-flex.gap-3 {
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>
    {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')

    <div class="notification-container">
        {{-- Hero Header --}}
        <div class="notification-hero">
            <div class="hero-content">
                <div class="hero-header">
                    <div class="hero-title">
                        <h3>
                            <i class="lni lni-bell"></i>
                            Notifikasi Saya
                        </h3>
                        <p>Tetap update dengan semua aktivitas tiket Anda</p>
                    </div>
                    @if($notifications->count() > 0)
                        <button id="markAllReadBtn" class="btn-mark-all-hero">
                            <i class="lni lni-checkmark-circle"></i>
                            Tandai Semua Dibaca
                        </button>
                    @endif
                </div>

                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-number">{{ $notifications->total() }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ $notifications->where('status_baca', false)->count() }}</div>
                        <div class="stat-label">Belum Dibaca</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ $notifications->where('status_baca', true)->count() }}</div>
                        <div class="stat-label">Sudah Dibaca</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert-modern alert-dismissible fade show" role="alert">
                <i class="lni lni-checkmark-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Notification List --}}
        <div class="notification-card-wrapper">
            @if($notifications->count() > 0)
                @foreach($notifications as $notif)
                    <div class="notification-item {{ !$notif->status_baca ? 'unread' : '' }}"
                         onclick="handleNotificationClick({{ $notif->notif_id }}, {{ $notif->tiket_id ?? 'null' }})">
                        <div class="d-flex gap-3 align-items-start">
                            <!-- Icon -->
                            <div class="notif-icon-box {{ !$notif->status_baca ? 'unread' : '' }}">
                                <i class="lni lni-{{ !$notif->status_baca ? 'envelope' : 'checkmark-circle' }}"></i>
                            </div>

                            <!-- Content -->
                            <div class="notif-content">
                                @if(!$notif->status_baca)
                                    <span class="badge-new">
                                        <i class="lni lni-bolt"></i>
                                        Baru
                                    </span>
                                @endif

                                <h6 class="notif-title">
                                    {{ $notif->judul ?? 'Pemberitahuan Tiket' }}
                                </h6>

                                <p class="notif-message">{{ $notif->pesan }}</p>

                                <div class="notif-meta">
                                    <span class="meta-item">
                                        <i class="lni lni-calendar"></i>
                                        {{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}
                                    </span>
                                    @if($notif->tiket)
                                        <span class="meta-item ticket">
                                            <i class="lni lni-tag"></i>
                                            Tiket #{{ $notif->tiket->kode_tiket }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="notif-actions dropdown" onclick="event.stopPropagation();">
                                <button class="dropdown-toggle-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="lni lni-cog"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(!$notif->status_baca)
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="markAsRead(event, {{ $notif->notif_id }})">
                                                <i class="lni lni-checkmark"></i> Tandai Dibaca
                                            </a>
                                        </li>
                                    @endif
                                    @if($notif->tiket_id)
                                        <li>
                                            <a class="dropdown-item" href="/tiket/{{ $notif->tiket_id }}">
                                                <i class="lni lni-eye"></i> Lihat Tiket
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('notifications.destroy', $notif->notif_id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Hapus notifikasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="lni lni-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="p-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-icon-wrapper">
                        <i class="lni lni-inbox"></i>
                    </div>
                    <h5>Belum Ada Notifikasi</h5>
                    <p>Notifikasi Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
    // Mark all as read - FIXED
    document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
        
        fetch('{{ route("notifications.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="lni lni-checkmark-circle"></i> Tandai Semua Dibaca';
        });
    });

    // Handle notification click
    function handleNotificationClick(notifId, tiketId) {
        if (tiketId) {
            fetch(`/notifications/${notifId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(() => {
                window.location.href = `/tiket/${tiketId}`;
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = `/tiket/${tiketId}`;
            });
        }
    }

    // Mark single as read
    function markAsRead(event, notifId) {
        event.preventDefault();
        event.stopPropagation();
        
        fetch(`/notifications/${notifId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    </script>
</body>
</html>