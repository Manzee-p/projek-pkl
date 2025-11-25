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
        
        {{-- Tombol Tandai Semua Dibaca --}}
        @if($notifications->where('status_baca', false)->count() > 0)
            <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </a>
        @endif
    </div>

    {{-- List Notifikasi --}}
    @forelse($notifications as $notif)
        <a href="{{ route('notifications.read', $notif->notif_id) }}" 
           class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 
                {{ !$notif->status_baca ? 'bg-light-primary' : '' }}"
                style="transition: 0.2s; cursor: pointer;">
                
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
                            <i class="bi bi-clock"></i> {{ $notif->waktu_kirim }}
                        </small>
                    </div>

                    <!-- Indikator Belum Dibaca -->
                    @if(!$notif->status_baca)
                        <div class="ms-2">
                            <span class="badge bg-primary rounded-circle" style="width: 10px; height: 10px; padding: 5px;"></span>
                        </div>
                    @endif
                </div>

            </div>
        </a>
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
@endsection