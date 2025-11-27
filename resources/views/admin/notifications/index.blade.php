@extends('layouts.admin.master')
@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Pusat Notifikasi</h4>
                        @if($notifications->where('status_baca', false)->count() > 0)
                            <button id="mark-all-read-btn" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-check-all"></i> Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-4">
                            <div class="alert alert-primary d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-bell-badge"></i> Total</span>
                                <strong>{{ $notifications->total() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-email-alert"></i> Belum Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', false)->count() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-check-circle"></i> Sudah Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', true)->count() }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive pt-2" style="overflow-x: auto;">
                        @if($notifications->count() > 0)
                        <table class="table table-bordered align-middle text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Pesan</th>
                                    <th width="180">Waktu</th>
                                    <th width="100" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $index => $notification)
                                <tr class="{{ !$notification->status_baca ? 'table-info' : '' }} notification-row"
                                    data-notif-id="{{ $notification->notif_id }}"
                                    data-tiket-id="{{ $notification->tiket_id ?? '' }}"
                                    style="cursor:pointer;">
                                    <td class="text-center align-middle">
                                        @if(!$notification->status_baca)
                                            <i class="mdi mdi-bell-ring text-primary"></i>
                                        @else
                                            <i class="mdi mdi-check text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $notification->pesan }}</strong><br>
                                        @if($notification->tiket)
                                            <small class="text-muted">
                                                <i class="mdi mdi-ticket-outline"></i> Tiket #{{ $notification->tiket->kode_tiket }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $notification->waktu_kirim->diffForHumans() }}
                                        </small><br>
                                        <small class="text-muted">{{ $notification->waktu_kirim->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenu{{ $notification->notif_id }}" 
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $notification->notif_id }}">
                                                @if($notification->tiket_id)
                                                <li>
                                                    <a class="dropdown-item view-tiket" 
                                                       href="#" 
                                                       data-notif-id="{{ $notification->notif_id }}"
                                                       data-tiket-id="{{ $notification->tiket_id }}">
                                                        <i class="mdi mdi-eye-outline me-2"></i> Lihat Tiket
                                                    </a>
                                                </li>
                                                @endif
                                                @if(!$notification->status_baca)
                                                <li>
                                                    <a class="dropdown-item mark-read-single" 
                                                       href="#" 
                                                       data-notif-id="{{ $notification->notif_id }}">
                                                        <i class="mdi mdi-check me-2"></i> Tandai Dibaca
                                                    </a>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger delete-notif" 
                                                       href="#"
                                                       data-notif-id="{{ $notification->notif_id }}">
                                                        <i class="mdi mdi-delete-outline me-2"></i> Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-bell-off-outline" style="font-size: 70px; color:#ccc;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada notifikasi</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript dengan Vanilla JS (No jQuery Dependency) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Notification page loaded');

    // 1. TANDAI SEMUA SEBAGAI DIBACA
    const markAllBtn = document.getElementById('mark-all-read-btn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            const originalHtml = btn.innerHTML;
            
            // Disable button
            btn.disabled = true;
            btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Memproses...';
            
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
                console.log('Mark all read response:', data);
                if (data.success) {
                    location.reload();
                } else {
                    throw new Error(data.message || 'Failed to mark all as read');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        });
    }

    // 2. KLIK BARIS NOTIFIKASI (redirect ke tiket)
    const notificationRows = document.querySelectorAll('.notification-row');
    notificationRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Jangan trigger jika klik di dropdown atau button
            if (e.target.closest('.dropdown, .dropdown-menu, .dropdown-toggle, button, a')) {
                return;
            }

            const notifId = this.dataset.notifId;
            const tiketId = this.dataset.tiketId;

            console.log('Row clicked:', { notifId, tiketId });

            if (tiketId) {
                // Tandai sebagai dibaca, lalu redirect
                fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Mark as read response:', data);
                    window.location.href = `/admin/tiket/${tiketId}`;
                })
                .catch(error => {
                    console.error('Error marking as read:', error);
                    // Tetap redirect meski gagal mark as read
                    window.location.href = `/admin/tiket/${tiketId}`;
                });
            }
        });
    });

    // 3. LIHAT TIKET (dari dropdown)
    const viewTiketLinks = document.querySelectorAll('.view-tiket');
    viewTiketLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notifId = this.dataset.notifId;
            const tiketId = this.dataset.tiketId;

            console.log('View tiket clicked:', { notifId, tiketId });

            // Tandai sebagai dibaca, lalu redirect
            fetch(`/notifications/${notifId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Mark as read response:', data);
                window.location.href = `/admin/tiket/${tiketId}`;
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = `/admin/tiket/${tiketId}`;
            });
        });
    });

    // 4. TANDAI SATU SEBAGAI DIBACA
    const markReadLinks = document.querySelectorAll('.mark-read-single');
    markReadLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notifId = this.dataset.notifId;
            console.log('Mark single as read:', notifId);

            fetch(`/notifications/${notifId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menandai sebagai dibaca');
            });
        });
    });

    // 5. HAPUS NOTIFIKASI
    const deleteLinks = document.querySelectorAll('.delete-notif');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (!confirm('Hapus notifikasi ini?')) {
                return;
            }

            const notifId = this.dataset.notifId;
            console.log('Delete notification:', notifId);

            fetch(`/notifications/${notifId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Delete response:', data);
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus notifikasi');
            });
        });
    });
});
</script>

@endsection