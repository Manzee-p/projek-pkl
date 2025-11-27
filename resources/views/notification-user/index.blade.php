@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container py-4">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/') }}" 
       class="btn btn-light shadow-sm mb-3"
       style="border-radius: 10px; font-weight: 600;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    {{-- Judul Halaman --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Notifikasi</h3>
        
        {{-- Tombol Tandai Semua Dibaca - FIXED --}}
        @if($notifications->where('status_baca', false)->count() > 0)
            <button id="markAllReadBtn" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
        @endif
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- List Notifikasi --}}
    @forelse($notifications as $notif)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 
            {{ !$notif->status_baca ? 'bg-light-primary' : '' }}"
            style="transition: 0.2s; cursor: pointer;"
            onclick="handleNotificationClick({{ $notif->notif_id }}, {{ $notif->tiket_id ?? 'null' }})">
            
            <div class="d-flex">
                <!-- Icon -->
                <div class="me-3 d-flex align-items-start">
                    <span class="badge {{ !$notif->status_baca ? 'bg-primary' : 'bg-secondary' }} rounded-circle p-3">
                        <i class="bi bi-bell-fill text-white"></i>
                    </span>
                </div>

                <!-- Isi Notifikasi -->
                <div class="flex-grow-1">
                    <strong class="d-block mb-1 {{ !$notif->status_baca ? 'text-dark' : 'text-muted' }}">
                        {!! nl2br(e($notif->pesan)) !!}
                    </strong>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> 
                        {{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}
                    </small>
                    @if($notif->tiket)
                        <span class="badge bg-info text-white ms-2">
                            <i class="bi bi-ticket"></i> {{ $notif->tiket->kode_tiket }}
                        </span>
                    @endif
                </div>

                <!-- Indikator Belum Dibaca -->
                @if(!$notif->status_baca)
                    <div class="ms-2">
                        <span class="badge bg-primary rounded-circle" style="width: 10px; height: 10px; padding: 5px;"></span>
                    </div>
                @endif
            </div>

        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash display-4 d-block mb-2"></i>
            Tidak ada notifikasi.
        </div>
    @endforelse

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $notifications->links() }}
    </div>

</div>

<style>
.bg-light-primary {
    background-color: #e7f3ff;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}
</style>

{{-- JavaScript untuk Handle Notifikasi --}}
<script>
// Tandai semua sebagai dibaca
document.getElementById('markAllReadBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    const btn = this;
    const originalHtml = btn.innerHTML;
    
    // Disable button dan show loading
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
        if (data.success) {
            // Reload halaman untuk update UI
            location.reload();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
        
        // Restore button state
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    });
});

// Handle klik notifikasi
function handleNotificationClick(notifId, tiketId) {
    // Tandai sebagai dibaca
    fetch(`/notifications/${notifId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect ke tiket jika ada
            if (tiketId) {
                window.location.href = `/tiket/${tiketId}`;
            } else {
                // Reload jika tidak ada tiket
                location.reload();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Tetap redirect meski ada error
        if (tiketId) {
            window.location.href = `/tiket/${tiketId}`;
        }
    });
}
</script>
@endsection