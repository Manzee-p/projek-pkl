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

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">

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
                <h3 class="fw-bold mb-1">📋 Laporan Saya</h3>
                <p class="text-muted mb-0">Kelola dan pantau semua laporan masalah Anda</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('report.history') }}" class="btn btn-warning">
                    <i class="lni lni-history"></i> Riwayat Laporan
                </a>
                <a href="{{ route('report.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Buat Laporan Baru
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="ti ti-check me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="ti ti-alert-triangle me-2 fs-5"></i>
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
                                    <i class="ti ti-list-details text-primary" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Total Laporan</p>
                                <h3 class="fw-bold mb-0">{{ $reports->count() }}</h3>
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
                                    <i class="ti ti-check text-success" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Selesai</p>
                                <h3 class="fw-bold mb-0">{{ $reports->where('status', 'selesai')->count() }}</h3>
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
                                    <i class="ti ti-loader text-warning" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Diproses</p>
                                <h3 class="fw-bold mb-0">{{ $reports->where('status', 'diproses')->count() }}</h3>
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
                                    <i class="ti ti-clock text-danger" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Pending</p>
                                <h3 class="fw-bold mb-0">{{ $reports->where('status', 'pending')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('report.index') }}" method="GET" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->kategori_id }}" {{ request('kategori_id') == $k->kategori_id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                                @if(request()->hasAny(['kategori_id', 'status', 'search']))
                                    <a href="{{ route('report.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                        <i class="ti ti-x"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Active Filter Indicator --}}
                    @if(request()->hasAny(['kategori_id', 'status', 'search']))
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <small class="text-muted fw-semibold">Filter Aktif:</small>
                                
                                @if(request('kategori_id'))
                                    @php
                                        $selectedKategori = $kategori->firstWhere('kategori_id', request('kategori_id'));
                                    @endphp
                                    <span class="badge bg-primary">
                                        Kategori: {{ $selectedKategori->nama_kategori ?? 'Unknown' }}
                                        <a href="{{ route('report.index', array_merge(request()->except('kategori_id'))) }}" class="text-white ms-1">×</a>
                                    </span>
                                @endif

                                @if(request('status'))
                                    <span class="badge bg-info">
                                        Status: {{ ucfirst(request('status')) }}
                                        <a href="{{ route('report.index', array_merge(request()->except('status'))) }}" class="text-white ms-1">×</a>
                                    </span>
                                @endif

                                @if(request('search'))
                                    <span class="badge bg-warning">
                                        Pencarian: "{{ request('search') }}"
                                        <a href="{{ route('report.index', array_merge(request()->except('search'))) }}" class="text-white ms-1">×</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Daftar Laporan</h5>
                    <span class="badge bg-secondary">
                        {{ $reports->count() }} laporan ditemukan
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-uppercase small">Judul & Deskripsi</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Status</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Tanggal</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Ditangani Oleh</th>
                                    <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr onclick="window.location='{{ route('report.show', $report->id) }}'"
                                        style="cursor: pointer;">
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $report->judul }}</div>
                                                @if ($report->deskripsi)
                                                    <small class="text-muted">
                                                        {{ Str::limit($report->deskripsi, 60) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-info bg-opacity-75">
                                                <i class="ti ti-tag"></i>
                                                {{ $report->kategori->nama_kategori ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @php
                                                $statusBadge = match ($report->status) {
                                                    'selesai' => 'bg-success',
                                                    'diproses' => 'bg-warning',
                                                    'ditolak' => 'bg-danger',
                                                    'pending' => 'bg-info',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusBadge }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted">
                                                <i class="ti ti-calendar me-1"></i>
                                                {{ $report->created_at->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                {{ $report->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                                                                <td class="py-3">
                                            @if ($report->assignedUser)
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                            style="width: 32px; height: 32px; font-size: 14px;">
                                                            {{ strtoupper(substr($report->assignedUser->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <small
                                                        class="fw-semibold">{{ Str::limit($report->assignedUser->name, 15) }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3" onclick="event.stopPropagation();">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('report.show', $report->id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('report.edit', $report->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit Laporan">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('report.destroy', $report->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus Laporan"
                                                        onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
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
                        @if(request()->hasAny(['kategori_id', 'status', 'search']))
                            <h5 class="text-muted mb-2">Tidak Ada Hasil</h5>
                            <p class="text-muted mb-4">
                                Tidak ada laporan yang sesuai dengan filter Anda.<br>
                                Coba ubah atau reset filter untuk melihat laporan lainnya.
                            </p>
                            <a href="{{ route('report.index') }}" class="btn btn-primary">
                                <i class="ti ti-refresh"></i> Reset Filter
                            </a>
                        @else
                            <h5 class="text-muted mb-2">Belum Ada Laporan</h5>
                            <p class="text-muted mb-4">
                                Anda belum memiliki laporan masalah.<br>
                                Buat laporan pertama Anda untuk melaporkan masalah.
                            </p>
                            <a href="{{ route('report.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Buat Laporan Pertama
                            </a>
                        @endif
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
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
            border-radius: 6px;
        }

        .badge i {
            font-size: 11px;
            margin-right: 2px;
        }

        /* Status Badge Colors */
        .badge.bg-success {
            background-color: #10b981 !important;
            color: white !important;
        }

        .badge.bg-primary {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        .badge.bg-warning {
            background-color: #f59e0b !important;
            color: white !important;
        }

        .badge.bg-danger {
            background-color: #ef4444 !important;
            color: white !important;
        }

        .badge.bg-info {
            background-color: #06b6d4 !important;
            color: white !important;
        }

        .badge.bg-secondary {
            background-color: #6b7280 !important;
            color: white !important;
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
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>