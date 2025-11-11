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
</head>
<body>
    {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')

    <div class="container-fluid px-4 py-4" style="min-height: calc(100vh - 200px);">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">🔔 Notifikasi Saya</h3>
                <p class="text-muted mb-0">Tetap update dengan semua aktivitas tiket Anda</p>
            </div>
            @if($notifications->count() > 0)
                <button id="markAllReadBtn" class="btn btn-primary">
                    <i class="lni lni-checkmark-circle"></i> Tandai Semua Dibaca
                </button>
            @endif
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-checkmark-circle me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Notifikasi List --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">Daftar Notifikasi</h5>
            </div>
            <div class="card-body p-0">
                @if($notifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notif)
                            <div class="list-group-item list-group-item-action {{ !$notif->status_baca ? 'bg-light border-start border-primary border-3' : '' }}" 
                                 style="cursor: pointer;"
                                 onclick="handleNotificationClick({{ $notif->notif_id }}, {{ $notif->tiket_id ?? 'null' }})">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="lni lni-{{ !$notif->status_baca ? 'envelope' : 'checkmark-circle' }} text-primary" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                @if(!$notif->status_baca)
                                                    <span class="badge bg-primary mb-1">
                                                        <i class="lni lni-bolt"></i> Baru
                                                    </span>
                                                @endif
                                                <h6 class="mb-1 {{ !$notif->status_baca ? 'fw-bold' : '' }}">
                                                    {{ $notif->judul ?? 'Pemberitahuan Tiket' }}
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-2 text-muted">{{ $notif->pesan }}</p>
                                        <div class="d-flex gap-3">
                                            <small class="text-muted">
                                                <i class="lni lni-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}
                                            </small>
                                            @if($notif->tiket)
                                                <small class="text-muted">
                                                    <i class="lni lni-tag me-1"></i>
                                                    Tiket #{{ $notif->tiket->kode_tiket }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="dropdown" onclick="event.stopPropagation();">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="lni lni-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if(!$notif->status_baca)
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="markAsRead(event, {{ $notif->notif_id }})">
                                                        <i class="lni lni-checkmark me-2"></i> Tandai Dibaca
                                                    </a>
                                                </li>
                                            @endif
                                            @if($notif->tiket_id)
                                                <li>
                                                    <a class="dropdown-item" href="/tiket/{{ $notif->tiket_id }}">
                                                        <i class="lni lni-eye me-2"></i> Lihat Tiket
                                                    </a>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('notifications.destroy', $notif->notif_id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Hapus notifikasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="lni lni-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="card-footer bg-white border-top">
                        {{ $notifications->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="lni lni-inbox" style="font-size: 80px; color: #ddd;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Notifikasi</h5>
                        <p class="text-muted mb-4">
                            Notifikasi Anda akan muncul di sini
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Include Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2021 © Mazer</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by 
                        <a href="http://ahmadsaugi.com" class="text-decoration-none">A. Saugi</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <style>
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }

    .list-group-item {
        border-left: none;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9ff !important;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 11px;
        letter-spacing: 0.3px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    /* Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: slideDown 0.3s ease;
    }
    </style>

    <script>
    // Tandai semua sebagai dibaca
    document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
        
        fetch('{{ route("notifications.readAll") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
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
            alert('Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = '<i class="lni lni-checkmark-circle"></i> Tandai Semua Dibaca';
        });
    });

    // Handle klik notifikasi
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
            });
        }
    }

    // Tandai satu notifikasi sebagai dibaca
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
        });
    }
    </script>
</body>
</html>