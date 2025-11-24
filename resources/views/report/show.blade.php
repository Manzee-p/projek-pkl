<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - {{ $report->judul }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
</head>
<body>
    @include('layouts.components-frontend.navbar')

    <div class="container py-4" style="min-height: calc(100vh - 200px);">
        {{-- Breadcrumb / Back Button --}}
        <div class="mb-4">
            <a href="{{ route('report.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="ti ti-arrow-left"></i> Kembali ke Laporan
            </a>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header Card with Title and Badges --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-2 text-dark">{{ $report->judul }}</h2>
                        <div class="d-flex flex-wrap gap-3 align-items-center text-muted small">
                            <span>
                                <i class="ti ti-calendar-event me-1"></i>
                                Dibuat {{ $report->created_at->format('d M Y, H:i') }}
                            </span>
                            <span>
                                <i class="ti ti-user me-1"></i>
                                {{ $report->user->name ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap align-items-start">
                        {{-- Badge Prioritas --}}
                        <span class="badge px-3 py-2 bg-{{ 
                            match(strtolower($report->prioritas->nama_prioritas ?? 'medium')) {
                                'urgent', 'tinggi' => 'danger',
                                'medium', 'sedang' => 'warning',
                                'rendah', 'low' => 'info',
                                default => 'secondary'
                            } 
                        }}">
                            <i class="ti ti-flag-filled me-1"></i>
                            {{ $report->prioritas->nama_prioritas ?? 'Medium' }}
                        </span>
                        
                        {{-- Badge Status --}}
                        <span class="badge px-3 py-2 bg-{{ 
                            match($report->status) {
                                'selesai' => 'success',
                                'diproses' => 'primary',
                                'pending' => 'warning',
                                'ditolak' => 'danger',
                                default => 'secondary'
                            } 
                        }}">
                            <i class="ti ti-{{ 
                                match($report->status) {
                                    'selesai' => 'check',
                                    'diproses' => 'loader',
                                    'pending' => 'clock',
                                    'ditolak' => 'x',
                                    default => 'help'
                                }
                            }} me-1"></i>
                            {{ ucfirst($report->status ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description Card --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">
                    <i class="ti ti-align-left me-2"></i>Deskripsi Laporan
                </h6>
                <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.7;">{{ $report->deskripsi }}</p>
            </div>
        </div>

                {{-- Info Cards Row --}}
                <div class="row g-3 mb-3">
                    {{-- Kategori --}}
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                            <i class="ti ti-tag text-primary fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Kategori</p>
                                        <h6 class="mb-0 fw-bold">{{ $report->kategori->nama_kategori ?? 'Tidak ada' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Assigned To --}}
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                            <i class="ti ti-user-check text-info fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Ditugaskan Ke</p>
                                        <h6 class="mb-0 fw-bold">
                                            {{ $report->assignedUser->name ?? 'Tim Konten' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Created Date --}}
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                            <i class="ti ti-clock text-success fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Dibuat</p>
                                        <h6 class="mb-0 fw-bold">{{ $report->created_at->diffForHumans() }}</h6>
                                        <small class="text-muted">{{ $report->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lampiran Section --}}
                @if($report->lampiran)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <h6 class="fw-semibold mb-3 text-uppercase small text-muted">
                                <i class="ti ti-paperclip me-2"></i>Lampiran
                            </h6>
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                <div class="flex-shrink-0">
                                    <i class="ti ti-file-text fs-1 text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold">File Lampiran</p>
                                    <small class="text-muted">{{ basename($report->lampiran) }}</small>
                                </div>
                                <a href="{{ Storage::url($report->lampiran) }}" target="_blank" 
                                   class="btn btn-primary btn-sm">
                                    <i class="ti ti-eye me-1"></i> Lihat File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 flex-wrap justify-content-between align-items-center">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('report.edit', $report->id) }}" class="btn btn-warning">
                                    <i class="ti ti-edit me-1"></i> Edit Laporan
                                </a>

                                <form action="{{ route('report.destroy', $report->id) }}" method="POST" 
                                    class="d-inline" onsubmit="return confirm('⚠️ Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ti ti-trash me-1"></i> Hapus Laporan
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('report.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-list me-1"></i> Lihat Semua Laporan
                            </a>
                        </div>
                    </div>
                </div>

        {{-- Timeline Section --}}
        <div class="card border-0 shadow-sm rounded-4 mt-3">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-4 text-uppercase small text-muted">
                    <i class="ti ti-history me-2"></i>Riwayat Perubahan
                </h6>
                <div class="timeline-container">
                    <div class="timeline-item">
                        <div class="timeline-dot bg-success"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-semibold mb-1">Laporan Dibuat</h6>
                                    <small class="text-muted">{{ $report->created_at->format('d M Y, H:i') }} WIB</small>
                                </div>
                                <span class="badge bg-success-subtle text-success">Created</span>
                            </div>
                        </div>
                    </div>

                    @if($report->updated_at != $report->created_at)
                    <div class="timeline-item">
                        <div class="timeline-dot bg-primary"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-semibold mb-1">Terakhir Diperbarui</h6>
                                    <small class="text-muted">{{ $report->updated_at->format('d M Y, H:i') }} WIB</small>
                                </div>
                                <span class="badge bg-primary-subtle text-primary">Updated</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($report->status == 'selesai')
                    <div class="timeline-item">
                        <div class="timeline-dot bg-success"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-semibold mb-1">Laporan Diselesaikan</h6>
                                    <small class="text-muted">{{ $report->updated_at->format('d M Y, H:i') }} WIB</small>
                                </div>
                                <span class="badge bg-success">Completed</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2025 © Helpdesk System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Dibuat dengan <span class="text-danger">❤️</span> oleh Tim Developer
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <style>
        body {
            background-color: #f5f7fa;
        }

        .card {
            transition: all 0.3s ease;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        h2 {
            color: #2c3e50;
            line-height: 1.4;
        }

        h6 {
            color: #495057;
        }

        p {
            line-height: 1.7;
            color: #4a5568;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            font-size: 0.875rem;
        }

        .timeline-container {
            position: relative;
            padding-left: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 45px;
            padding-bottom: 30px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 24px;
            height: calc(100% - 12px);
            width: 2px;
            background: linear-gradient(180deg, #e0e7ff 0%, #f0f4f8 100%);
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 12px;
            border-left: 3px solid #e0e7ff;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            background: #fff;
            border-left-color: #6366f1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateX(2px);
        }

        .badge.bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.1) !important;
            color: #15803d !important;
        }

        .badge.bg-primary-subtle {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #1e40af !important;
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Card hover effect */
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animation delay for cards */
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</body>
</html>