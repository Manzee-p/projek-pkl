<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - {{ $report->judul }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
</head>
<body>
    @include('layouts.components-frontend.navbar')

    <div class="container py-5" style="min-height: calc(100vh - 200px);">
        <div class="mb-4">
            <a href="{{ route('report.index') }}" class="btn btn-outline-secondary">
                <i class="lni lni-arrow-left"></i> Kembali ke Laporan
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold mb-0">{{ $report->judul }}</h3>
                    <span class="badge bg-{{ 
                        match($report->prioritas) {
                            'urgent' => 'danger',
                            'tinggi' => 'warning',
                            'sedang' => 'primary',
                            'rendah' => 'secondary',
                            default => 'secondary'
                        } 
                    }}">
                        {{ ucfirst($report->prioritas) }}
                    </span>
                </div>

                <p class="text-muted mb-3">
                    <i class="lni lni-calendar"></i> 
                    Dibuat pada {{ $report->created_at->format('d M Y, H:i') }}
                </p>

                <div class="mb-4">
                    <h6 class="fw-semibold text-uppercase text-muted small">Deskripsi</h6>
                    <p class="mt-2">{{ $report->deskripsi }}</p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-1">Kategori</h6>
                            <p class="mb-0">
                                {{ $report->kategori ?? 'Tidak ditentukan' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-1">Status</h6>
                            <p class="mb-0">
                                @php
                                    $statusClass = match($report->status) {
                                        'selesai' => 'text-success',
                                        'proses' => 'text-warning',
                                        'menunggu' => 'text-secondary',
                                        default => 'text-muted'
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($report->status ?? 'Menunggu') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                @if($report->lampiran)
                    <div class="mb-4">
                        <h6 class="fw-semibold text-uppercase text-muted small mb-2">Lampiran</h6>
                        <a href="{{ Storage::url($report->lampiran) }}" target="_blank" class="btn btn-outline-info">
                            <i class="lni lni-eye"></i> Lihat Lampiran
                        </a>
                    </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('report.edit', $report->id) }}" class="btn btn-warning">
                        <i class="lni lni-pencil"></i> Edit Laporan
                    </a>

                    <form action="{{ route('report.destroy', $report->id) }}" method="POST" 
                        onsubmit="return confirm('⚠️ Yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="lni lni-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container text-center text-muted small">
            <p class="mb-0">2025 © Helpdesk | Dibuat dengan ❤️ oleh Tim Developer</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <style>
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h3 {
            color: #2c3e50;
        }
        p {
            line-height: 1.6;
        }
    </style>
</body>
</html>
