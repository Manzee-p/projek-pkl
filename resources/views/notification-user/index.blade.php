@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container py-4">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/') }}" 
       class="btn btn-light shadow-sm mb-3"
       style="border-radius: 10px; font-weight: 600;">
        <i class="bi bi-arrow-left"></i> 
    </a>

    {{-- Judul Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <h3 class="mb-0">Notifikasi</h3>
    </div>

    {{-- List Notifikasi --}}
    @forelse($notifs as $notif)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 
            {{ !$notif->status_baca ? 'bg-light-primary' : '' }}"
            style="transition: 0.2s;">
            
            <div class="d-flex">
                <!-- Icon -->
                <div class="me-3 d-flex align-items-start">
                    <span class="badge bg-primary rounded-circle p-3">
                        <i class="bi bi-bell-fill text-white"></i>
                    </span>
                </div>

                <!-- Isi Notifikasi -->
                <div>
                    <strong class="d-block mb-1">{!! nl2br(e($notif->pesan)) !!}</strong>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> {{ $notif->waktu_kirim }}
                    </small>
                </div>
            </div>

        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash display-4 d-block mb-2"></i>
            Tidak ada notifikasi.
        </div>
    @endforelse

</div>
@endsection