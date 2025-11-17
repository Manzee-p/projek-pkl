@extends('layouts.admin.master')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Yeay! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

{{-- Header Section --}}
<div class="container-fluid px-3">
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">📊 Dashboard Evaluasi & Feedback</h3>
                <p class="text-muted mb-0">Monitoring kualitas layanan berdasarkan feedback user</p>
            </div>
            <a href="{{ route('admin.tiket.index') }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> Kembali ke Tiket
            </a>
        </div>
    </div>
</div>

{{-- Rating Overview Cards --}}
<div class="row">
    {{-- Average Rating Card --}}
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="text-white fw-semibold mb-1">Rating Rata-rata</h5>
                        <small class="text-white-50">Keseluruhan layanan</small>
                    </div>
                    <i class="mdi mdi-star" style="font-size: 2.5rem; opacity: 0.5;"></i>
                </div>
                <div class="text-center my-3">
                    <h1 class="display-3 fw-bold mb-2">
                        {{ number_format($averageRating, 1) }}
                        <span class="h3 fw-normal">/5.0</span>
                    </h1>
                    <div class="mb-2" style="font-size: 1.8rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= round($averageRating) ? '⭐' : '☆' }}</span>
                        @endfor
                    </div>
                    <small class="text-white-50">Dari {{ $ratingStats->sum('total') }} penilaian</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Rating Distribution --}}
    <div class="col-lg-8 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-chart-bar text-primary"></i> Distribusi Rating
                </h5>
                @foreach($ratingStats->sortByDesc('rating') as $stat)
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div style="min-width: 100px;">
                                <span style="font-size: 1.2rem;">{{ str_repeat('⭐', $stat->rating) }}</span>
                            </div>
                            <div class="flex-grow-1 mx-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                        style="width: {{ ($stat->total / $ratingStats->sum('total')) * 100 }}%"
                                        aria-valuenow="{{ $stat->total }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div style="min-width: 100px;" class="text-end">
                                <span class="fw-bold">{{ $stat->total }}</span>
                                <small class="text-muted">({{ number_format(($stat->total / $ratingStats->sum('total')) * 100, 1) }}%)</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Tipe Komentar Stats --}}
<div class="row">
    @foreach($tipeStats as $tipe)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-1 
                                @if($tipe->tipe_komentar === 'feedback') text-primary
                                @elseif($tipe->tipe_komentar === 'evaluasi') text-success
                                @else text-danger
                                @endif">
                                @if($tipe->tipe_komentar === 'feedback')
                                    <i class="mdi mdi-thumb-up"></i> Feedback Positif
                                @elseif($tipe->tipe_komentar === 'evaluasi')
                                    <i class="mdi mdi-chart-line"></i> Evaluasi
                                @else
                                    <i class="mdi mdi-alert"></i> Keluhan
                                @endif
                            </h6>
                            <small class="text-muted">Total komentar masuk</small>
                        </div>
                        <h2 class="fw-bold mb-0 
                            @if($tipe->tipe_komentar === 'feedback') text-primary
                            @elseif($tipe->tipe_komentar === 'evaluasi') text-success
                            @else text-danger
                            @endif">
                            {{ $tipe->total }}
                        </h2>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar 
                            @if($tipe->tipe_komentar === 'feedback') bg-primary
                            @elseif($tipe->tipe_komentar === 'evaluasi') bg-success
                            @else bg-danger
                            @endif" 
                            role="progressbar" 
                            style="width: {{ ($tipe->total / $tipeStats->sum('total')) * 100 }}%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        {{ number_format(($tipe->total / $tipeStats->sum('total')) * 100, 1) }}% dari total
                    </small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    {{-- Performa Tim --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-account-group text-primary"></i> Performa Tim
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tim Support</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Komentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($timStats as $stat)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-icon-prepend bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                                style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($stat['user']->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $stat['user']->name }}</div>
                                                <small class="text-muted">{{ $stat['user']->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-bold text-warning mb-1" style="font-size: 1.2rem;">
                                            ⭐ {{ $stat['avg_rating'] }}
                                        </div>
                                        <div class="progress" style="height: 4px; width: 80px; margin: 0 auto;">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                style="width: {{ ($stat['avg_rating'] / 5) * 100 }}%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary">
                                            {{ $stat['total_komentar'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="mdi mdi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada data performa tim</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Keluhan Prioritas --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-bold mb-0">
                        <i class="mdi mdi-alert text-danger"></i> Keluhan & Rating Rendah
                    </h5>
                    <span class="badge badge-danger">{{ $complaints->count() }}</span>
                </div>
                <div style="max-height: 450px; overflow-y: auto;">
                    @forelse($complaints as $complaint)
                        <div class="border-start border-4 border-danger bg-light p-3 mb-3 rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-dark">{{ $complaint->user->name }}</div>
                                    <small class="text-muted">
                                        <i class="mdi mdi-ticket"></i> 
                                        {{ $complaint->tiket->kode_tiket }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="mb-1">{{ str_repeat('⭐', $complaint->rating) }}</div>
                                    <span class="badge 
                                        @if($complaint->tipe_komentar === 'complaint') badge-danger
                                        @else badge-warning
                                        @endif">
                                        {{ ucfirst($complaint->tipe_komentar) }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-dark small mb-2">{{ Str::limit($complaint->komentar, 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="mdi mdi-clock-outline"></i> 
                                    {{ $complaint->waktu_komentar->diffForHumans() }}
                                </small>
                                <a href="{{ route('admin.tiket.show', $complaint->tiket_id) }}" 
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="mdi mdi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-3 mb-0">Tidak ada keluhan saat ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Komentar Terbaru --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <i class="mdi mdi-comment-text text-primary"></i> Komentar Terbaru
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User & Tiket</th>
                                <th>Komentar</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Rating</th>
                                <th>Waktu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentKomentars as $komentar)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $komentar->user->name }}</div>
                                        <small class="text-primary">
                                            <i class="mdi mdi-ticket"></i> 
                                            {{ $komentar->tiket->kode_tiket }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($komentar->komentar, 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge 
                                            @if($komentar->tipe_komentar === 'feedback') badge-primary
                                            @elseif($komentar->tipe_komentar === 'evaluasi') badge-success
                                            @else badge-danger
                                            @endif">
                                            {{ ucfirst($komentar->tipe_komentar) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span style="font-size: 1.2rem;">{{ str_repeat('⭐', $komentar->rating) }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $komentar->waktu_komentar->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tiket.show', $komentar->tiket_id) }}" 
                                            class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="mt-3 mb-0">Belum ada komentar</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .progress {
        border-radius: 10px;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
    }

        .dashboard-card {
        border-radius: 14px;
        border: none;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: 0.25s ease;
        background: #fff;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .rating-big-number {
        font-size: 3.2rem !important;
        line-height: 1;
        font-weight: 700;
    }

    /* Pastikan kolom tidak over-width */
    .row { 
        row-gap: 20px;
    }

    /* Perbaiki teks panjang agar tidak melebar */
    .text-wrap {
        white-space: normal !important;
        word-break: break-word !important;
    }

    /* Fix progress bar */
    .progress {
        height: 8px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Table styling */
    table.table td {
        vertical-align: middle;
        white-space: normal !important;
    }

    .rating-stars span {
        font-size: 1.3rem;
    }

    /* Scroll area untuk bagian keluhan */
    .scroll-area {
        max-height: 360px;
        overflow-y: auto;
        padding-right: 8px;
    }

    /* Hide scrollbar but keep scroll functionality */
    .scroll-area::-webkit-scrollbar {
        width: 6px;
    }
    .scroll-area::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }
</style>

@endsection 