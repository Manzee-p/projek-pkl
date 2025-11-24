@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Tiket Saya')

@section('content')
<div class="container tiket-container px-4 py-4">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">📋 Tiket Saya</h3>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tiket.history') }}" class="nav-link btn btn-warning">
                    <i class="fas fa-history"></i> Riwayat Tiket
                </a>
                <a href="{{ route('tiket.create') }}" class="btn btn-primary">
                    <i class="lni lni-plus"></i> Buat Tiket Baru
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-checkmark-circle me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-warning me-2 fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Statistik Card --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="lni lni-inbox text-primary" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Total Tiket</p>
                                <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                    <i class="lni lni-checkmark-circle text-success" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Selesai</p>
                                <h3 class="fw-bold mb-0">{{ $stats['selesai'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="lni lni-timer text-warning" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Diproses</p>
                                <h3 class="fw-bold mb-0">{{ $stats['diproses'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                    <i class="lni lni-cross-circle text-danger" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Ditolak</p>
                                <h3 class="fw-bold mb-0">{{ $stats['ditolak'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik per Kategori --}}
        @if ($kategoriStats->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="lni lni-bar-chart text-primary"></i> Statistik per Kategori
                            </h5>
                            <div class="row g-3">
                                @foreach ($kategoriStats as $stat)
                                    <div class="col-md-3">
                                        <div class="border rounded-3 p-3 bg-light">
                                            <p class="text-muted mb-1 small">
                                                {{ $stat->kategori->nama_kategori ?? 'N/A' }}</p>
                                            <h4 class="mb-0 fw-bold text-primary">{{ $stat->total }} <span
                                                    class="small fw-normal text-muted">tiket</span></h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('tiket.history') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">
                                <i class="lni lni-search-alt text-primary"></i> Cari Tiket
                            </label>
                            <input type="text" name="search" class="form-control"
                                placeholder="Judul atau kode tiket..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">
                                <i class="lni lni-calendar text-primary"></i> Dari Tanggal
                            </label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">
                                <i class="lni lni-calendar text-primary"></i> Sampai Tanggal
                            </label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status_id" class="form-select">
                                <option value="">Semua Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->status_id }}"
                                        {{ request('status_id') == $status->status_id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="kategori_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}"
                                        {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label class="form-label fw-semibold small d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="lni lni-funnel"></i>
                            </button>
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id']))
                        <div class="mt-3">
                            <a href="{{ route('tiket.history') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="lni lni-close"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Riwayat Tiket --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Daftar Tiket Terbaru</h5>
                <span class="badge bg-primary">{{ $tikets->count() }} tiket</span>
            </div>
            <div class="card-body p-0">
                @if ($tikets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-uppercase small">Kode & Judul</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Tanggal Dibuat</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Ditangani Oleh</th>
                                    <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tikets as $tiket)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="text-primary fw-semibold small mb-1">
                                                    #{{ $tiket->kode_tiket }}
                                                </div>
                                                <div class="fw-semibold text-dark">{{ Str::limit($tiket->judul, 40) }}
                                                </div>
                                                @if ($tiket->event)
                                                    <small class="text-muted">
                                                        <i class="lni lni-bookmark"></i>
                                                        {{ $tiket->event->nama_event }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-info bg-opacity-75">
                                                <i class="lni lni-tag"></i>
                                                {{ $tiket->kategori->nama_kategori ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted d-block">
                                                <i class="lni lni-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}
                                            </small>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td class="py-3">
                                            @if ($tiket->assignedTo)
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                            style="width: 32px; height: 32px; font-size: 14px;">
                                                            {{ strtoupper(substr($tiket->assignedTo->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <small
                                                        class="fw-semibold">{{ Str::limit($tiket->assignedTo->name, 15) }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('tiket.show', $tiket->tiket_id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Lihat Detail">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-50">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                        </div>
                        <h5 class="text-muted mb-2">Tidak ada riwayat tiket ditemukan</h5>
                        <p class="text-muted mb-4">Belum ada tiket yang sesuai dengan filter Anda</p>
                        @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id']))
                            <a href="{{ route('tiket.history') }}" class="btn btn-primary">
                                <i class="lni lni-reload"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
    {{-- Include Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2025 © Helpdesk System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by Your Team
                    </p>
                </div>
            </div>
        </div>
    </footer>
@push('styles')
<style>
    /* Perlebar container di halaman ini saja */
    .tiket-container {
    max-width: 1900px !important;
}

</style>
@endpush

    
  @endsection