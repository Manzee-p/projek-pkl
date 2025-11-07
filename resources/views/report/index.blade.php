<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Saya - Helpdesk</title>

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

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
</head>

<body>
    {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')

    <div class="container-fluid px-4 py-5" style="min-height: calc(100vh - 200px);">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">📋 Laporan Saya</h3>
                <p class="text-muted mb-0">Kelola semua laporan masalah Anda di sini</p>
            </div>
            <a href="{{ route('report.create') }}" class="btn btn-primary">
                <i class="lni lni-plus"></i> Buat Laporan Baru
            </a>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="lni lni-checkmark-circle me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
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
                                    <i class="lni lni-files text-primary" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Total Laporan</p>
                                <h3 class="fw-bold mb-0">{{ $reports->total() }}</h3>
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
                                    <i class="lni lni-checkmark text-success" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Selesai</p>
                                <h3 class="fw-bold mb-0">0</h3>
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
                                <p class="text-muted mb-1 small">Proses</p>
                                <h3 class="fw-bold mb-0">{{ $reports->total() }}</h3>
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
                                    <i class="lni lni-bolt text-danger" style="font-size: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Urgent</p>
                                <h3 class="fw-bold mb-0">{{ $reports->where('prioritas', 'urgent')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">Daftar Laporan</h5>
            </div>
            <div class="card-body p-0">
                @if ($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-uppercase small">Judul</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Prioritas</th>
                                    <th class="py-3 fw-semibold text-uppercase small">Tanggal</th>
                                    <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold text-dark mb-1">{{ $report->judul }}</div>
                                                <small class="text-muted">
                                                    {{ Str::limit($report->deskripsi, 60) }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @php
                                                $kategoriIcon = match ($report->kategori) {
                                                    'Teknis' => '🔧',
                                                    'Akun' => '👤',
                                                    'Fitur' => '⚙️',
                                                    'Bug' => '🐛',
                                                    default => '📌',
                                                };
                                            @endphp
                                            <span class="badge bg-info bg-opacity-75">
                                                {{ $kategoriIcon }} {{ $report->kategori }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @php
                                                $prioritasConfig = match ($report->prioritas) {
                                                    'urgent' => ['class' => 'danger', 'icon' => '🔴'],
                                                    'tinggi' => ['class' => 'warning', 'icon' => '🟠'],
                                                    'sedang' => ['class' => 'primary', 'icon' => '🔵'],
                                                    'rendah' => ['class' => 'secondary', 'icon' => '🟢'],
                                                    default => ['class' => 'secondary', 'icon' => '⚪'],
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $prioritasConfig['class'] }}">
                                                {{ $prioritasConfig['icon'] }} {{ ucfirst($report->prioritas) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted">
                                                <i class="lni lni-calendar me-1"></i>
                                                {{ $report->created_at->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                {{ $report->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('report.show', $report->id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Show Laporan">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                                <a href="{{ route('report.edit', $report->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit Laporan">
                                                    <i class="lni lni-pencil"></i>
                                                </a>
                                                <form action="{{ route('report.destroy', $report->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('⚠️ Yakin ingin hapus laporan ini?\n\nData yang sudah dihapus tidak bisa dikembalikan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus Laporan">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($reports->hasPages())
                        <div class="p-3 border-top bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Menampilkan {{ $reports->firstItem() }} - {{ $reports->lastItem() }}
                                    dari {{ $reports->total() }} laporan
                                </div>
                                <div>
                                    {{ $reports->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
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
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Laporan</h5>
                        <p class="text-muted mb-4">
                            Anda belum membuat laporan apapun.<br>
                            Buat laporan pertama Anda untuk melaporkan masalah atau keluhan.
                        </p>
                        <a href="{{ route('report.create') }}" class="btn btn-primary">
                            <i class="lni lni-plus"></i> Buat Laporan Pertama
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
