<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Tiket - Support Ticket System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: transform 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .badge {
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: #667eea;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Header -->

        @include('layouts.components-frontend.navbar')

        <div class="row mb-4 mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: #1e293b;">
                            <i class="fas fa-clipboard-list" style="color: #ff6b6b;"></i> Riwayat Tiket Saya
                        </h2>
                        <p class="text-muted mb-0">History semua tiket yang pernah Anda buat</p>
                    </div>
                    <div>
                        <a href="{{ route('tiket.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Tiket Aktif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Card -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                                    <i class="fas fa-ticket-alt text-white" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Total Tiket</p>
                                <h2 class="mb-0 fw-bold" style="color: #1e293b;">{{ $stats['total'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 12px;">
                                    <i class="fas fa-check-circle text-white" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Selesai</p>
                                <h2 class="mb-0 fw-bold" style="color: #1e293b;">{{ $stats['selesai'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px;">
                                    <i class="fas fa-spinner text-white" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Diproses</p>
                                <h2 class="mb-0 fw-bold" style="color: #1e293b;">{{ $stats['diproses'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px;">
                                    <i class="fas fa-times-circle text-white" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small">Ditolak</p>
                                <h2 class="mb-0 fw-bold" style="color: #1e293b;">{{ $stats['ditolak'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik per Kategori -->
        @if ($kategoriStats->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4" style="color: #1e293b;">
                                <i class="fas fa-chart-bar" style="color: #667eea;"></i> Statistik per Kategori
                            </h5>
                            <div class="row g-3">
                                @foreach ($kategoriStats as $stat)
                                    <div class="col-md-3">
                                        <div class="border-0 rounded-3 p-3"
                                            style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);">
                                            <p class="text-muted mb-1 small">
                                                {{ $stat->kategori->nama_kategori ?? 'N/A' }}</p>
                                            <h4 class="mb-0 fw-bold" style="color: #1e40af;">{{ $stat->total }} <span
                                                    class="small fw-normal">tiket</span></h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('tiket.history') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-search text-primary"></i> Cari Tiket
                            </label>
                            <input type="text" name="search" class="form-control"
                                style="border-radius: 8px; border: 1px solid #e2e8f0;"
                                placeholder="Judul atau kode tiket..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-calendar text-primary"></i> Dari Tanggal
                            </label>
                            <input type="date" name="start_date" class="form-control"
                                style="border-radius: 8px; border: 1px solid #e2e8f0;"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-calendar text-primary"></i> Sampai Tanggal
                            </label>
                            <input type="date" name="end_date" class="form-control"
                                style="border-radius: 8px; border: 1px solid #e2e8f0;"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status_id" class="form-select"
                                style="border-radius: 8px; border: 1px solid #e2e8f0;">
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
                            <select name="kategori_id" class="form-select"
                                style="border-radius: 8px; border: 1px solid #e2e8f0;">
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
                            <button type="submit" class="btn btn-primary w-100"
                                style="border-radius: 8px; height: 38px;">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id', 'prioritas_id']))
                        <div class="mt-3">
                            <a href="{{ route('tiket.history') }}"
                                class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                <i class="fas fa-times me-1"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Tabel Riwayat Tiket -->
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4"
                style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #1e293b;">Daftar Riwayat Tiket</h5>
                <span class="badge rounded-pill px-3 py-2"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    {{ $tikets->total() }} tiket
                </span>
            </div>
            <div class="card-body p-0">
                @if ($tikets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8fafc;">
                                <tr>
                                    <th class="border-0 py-3 px-4 fw-semibold small text-muted">KODE TIKET</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">JUDUL</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">KATEGORI</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">PRIORITAS</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">STATUS</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">TANGGAL DIBUAT</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted">DITANGANI OLEH</th>
                                    <th class="border-0 py-3 fw-semibold small text-muted text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tikets as $tiket)
                                    <tr class="align-middle">
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-primary fw-semibold px-3 py-2"
                                                style="border-radius: 8px;">
                                                {{ $tiket->kode_tiket }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold mb-1"
                                                    style="color: #1e293b;">{{ Str::limit($tiket->judul, 40) }}</span>
                                                @if ($tiket->event)
                                                    <small class="text-muted">
                                                        <i
                                                            class="fas fa-calendar-alt me-1"></i>{{ $tiket->event->nama_event }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background-color: #dbeafe; color: #1e40af;">
                                                {{ $tiket->kategori->nama_kategori ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @if ($tiket->prioritas)
                                                @php
                                                    $badgeStyle = match ($tiket->prioritas->nama_prioritas) {
                                                        'Urgent'
                                                            => 'background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;',
                                                        'High'
                                                            => 'background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;',
                                                        'Normal' => 'background-color: #dbeafe; color: #1e40af;',
                                                        'Low' => 'background-color: #f1f5f9; color: #64748b;',
                                                        default => 'background-color: #f1f5f9; color: #64748b;',
                                                    };
                                                @endphp
                                                <span class="badge rounded-pill px-3 py-2"
                                                    style="{{ $badgeStyle }}">
                                                    {{ $tiket->prioritas->nama_prioritas }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            @if ($tiket->status)
                                                @php
                                                    $statusStyle = match ($tiket->status->nama_status) {
                                                        'Selesai'
                                                            => 'background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;',
                                                        'Sedang Diproses'
                                                            => 'background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;',
                                                        'Ditolak'
                                                            => 'background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;',
                                                        'Baru' => 'background-color: #dbeafe; color: #1e40af;',
                                                        default => 'background-color: #f1f5f9; color: #64748b;',
                                                    };
                                                @endphp
                                                <span class="badge rounded-pill px-3 py-2"
                                                    style="{{ $statusStyle }}">
                                                    {{ $tiket->status->nama_status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <small class="d-block fw-semibold" style="color: #1e293b;">
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
                                                        <div class="d-flex align-items-center justify-content-center text-white fw-bold"
                                                            style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                            {{ strtoupper(substr($tiket->assignedTo->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <small class="fw-semibold"
                                                        style="color: #1e293b;">{{ Str::limit($tiket->assignedTo->name, 15) }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-center">
                                            <a href="{{ route('tiket.show', $tiket->tiket_id) }}"
                                                class="btn btn-sm btn-light text-primary fw-semibold"
                                                style="border-radius: 8px;" title="Lihat Detail">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 border-top">
                        {{ $tikets->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2" style="color: #64748b;">Tidak ada riwayat tiket ditemukan</h5>
                        <p class="text-muted mb-4">Belum ada tiket yang sesuai dengan filter Anda</p>
                        @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id']))
                            <a href="{{ route('tiket.history') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-redo me-2"></i>Reset Filter
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
