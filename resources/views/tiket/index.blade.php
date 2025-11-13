<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya - Helpdesk</title>

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
                <h3 class="fw-bold mb-1">🎫 Tiket Saya</h3>
                <p class="text-muted mb-0">Kelola dan pantau semua tiket support Anda</p>
            </div>
            <a href="{{ route('tiket.create') }}" class="btn btn-primary">
                <i class="lni lni-plus"></i> Buat Tiket Baru
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-checkmark-circle me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-warning me-2 fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Statistik Card --}}
        <div class="row g-3 mb-4 justify-content-center">
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
                                <p class="text-muted mb-1 small">Open</p>
                                <h3 class="fw-bold mb-0">{{ $tikets->where('status.nama_status', 'Open')->count() }}</h3>
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
                                <p class="text-muted mb-1 small">In Progress</p>
                                <h3 class="fw-bold mb-0">{{ $tikets->where('status.nama_status', 'In Progress')->count() }}</h3>
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
                                <p class="text-muted mb-1 small">Resolved</p>
                                <h3 class="fw-bold mb-0">{{ $tikets->where('status.nama_status', 'Resolved')->count() }}</h3>
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
                                <div class="bg-secondary bg-opacity-10 rounded-3 p-3">
                                    <i class="lni lni-lock text-secondary" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Closed</p>
                                <h3 class="fw-bold mb-0">{{ $tikets->where('status.nama_status', 'Closed')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('tiket.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status_id" class="form-select">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->status_id }}" {{ request('status_id') == $status->status_id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="kategori_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Prioritas</label>
                            <select name="prioritas_id" class="form-select">
                                <option value="">Semua Prioritas</option>
                                @foreach($prioritas as $prior)
                                    <option value="{{ $prior->prioritas_id }}" {{ request('prioritas_id') == $prior->prioritas_id ? 'selected' : '' }}>
                                        {{ $prior->nama_prioritas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="lni lni-search-alt"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Tiket --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">Daftar Tiket</h5>
            </div>
            <div class="card-body p-0">
                @if($tikets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-uppercase small">Kode & Judul</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Event</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Tanggal</th>
                                    <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tikets as $tiket)
                                    <tr onclick="window.location='{{ route('tiket.show', $tiket->tiket_id) }}'" style="cursor: pointer;">
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="text-primary fw-semibold small mb-1">#{{ $tiket->kode_tiket }}</div>
                                                <div class="fw-semibold text-dark">{{ $tiket->judul }}</div>
                                                @if($tiket->deskripsi)
                                                    <small class="text-muted">
                                                        {{ Str::limit($tiket->deskripsi, 60) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-info bg-opacity-75">
                                                <i class="lni lni-tag"></i> {{ $tiket->kategori->nama_kategori }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted">
                                                <i class="lni lni-bookmark"></i> {{ $tiket->event->nama_event }}
                                            </small>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted">
                                                <i class="lni lni-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td class="py-3" onclick="event.stopPropagation();">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('tiket.show', $tiket->tiket_id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   data-bs-toggle="tooltip"
                                                   title="Lihat Detail">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                                <a href="{{ route('tiket.edit', $tiket->tiket_id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   data-bs-toggle="tooltip"
                                                   title="Edit Tiket">
                                                    <i class="lni lni-pencil"></i>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-50">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Tiket</h5>
                        <p class="text-muted mb-4">
                            Anda belum memiliki tiket support.<br>
                            Buat tiket pertama Anda untuk mendapatkan bantuan.
                        </p>
                        <a href="{{ route('tiket.create') }}" class="btn btn-primary">
                            <i class="lni lni-plus"></i> Buat Tiket Pertama
                        </a>
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

    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 11px;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9ff;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
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

    .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
    }

    .form-select:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
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
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>