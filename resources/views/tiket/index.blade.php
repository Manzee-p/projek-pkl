<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tiket - Web Helpdesk</title>
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="lni lni-ticket-alt"></i> Web Helpdesk
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="container">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="lni lni-checkmark-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="lni lni-warning"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="lni lni-ticket"></i> Tiket Saya</h1>
                        <p class="text-muted mb-0">Kelola dan pantau semua tiket support Anda</p>
                    </div>
                    <a href="{{ route('tiket.create') }}" class="btn btn-primary-custom">
                        <i class="lni lni-plus"></i> Buat Tiket Baru
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card open">
                        <div class="d-flex align-items-center">
                            <i class="lni lni-inbox" style="font-size: 2rem; color: var(--primary);"></i>
                            <div class="ms-3">
                                <div class="text-muted small">Open</div>
                                <div class="stats-number" style="color: var(--primary);">
                                    {{ $tikets->where('status.nama_status', 'Open')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card progress">
                        <div class="d-flex align-items-center">
                            <i class="lni lni-timer" style="font-size: 2rem; color: var(--warning);"></i>
                            <div class="ms-3">
                                <div class="text-muted small">In Progress</div>
                                <div class="stats-number" style="color: var(--warning);">
                                    {{ $tikets->where('status.nama_status', 'In Progress')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card resolved">
                        <div class="d-flex align-items-center">
                            <i class="lni lni-checkmark-circle" style="font-size: 2rem; color: var(--success);"></i>
                            <div class="ms-3">
                                <div class="text-muted small">Resolved</div>
                                <div class="stats-number" style="color: var(--success);">
                                    {{ $tikets->where('status.nama_status', 'Resolved')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card closed">
                        <div class="d-flex align-items-center">
                            <i class="lni lni-lock" style="font-size: 2rem; color: #6B778C;"></i>
                            <div class="ms-3">
                                <div class="text-muted small">Closed</div>
                                <div class="stats-number" style="color: #6B778C;">
                                    {{ $tikets->where('status.nama_status', 'Closed')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('tiket.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Status</label>
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
                            <label class="form-label small fw-bold">Kategori</label>
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
                            <label class="form-label small fw-bold">Prioritas</label>
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
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="lni lni-search-alt"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tiket List -->
            @if($tikets->count() > 0)
                <div class="row">
                    <div class="col-12">
                        @foreach($tikets as $tiket)
                            <div class="tiket-card" onclick="window.location='{{ route('tiket.show', $tiket->tiket_id) }}'">
                                <div class="tiket-header">
                                    <div>
                                        <div class="tiket-code">#{{ $tiket->kode_tiket }}</div>
                                        <h5 class="tiket-title">{{ $tiket->judul }}</h5>
                                    </div>
                                    <div class="text-end">
                                        @php
                                            $statusClass = 'badge-open';
                                            if($tiket->status->nama_status == 'In Progress') $statusClass = 'badge-progress';
                                            elseif($tiket->status->nama_status == 'Resolved') $statusClass = 'badge-resolved';
                                            elseif($tiket->status->nama_status == 'Closed') $statusClass = 'badge-closed';
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">
                                            {{ $tiket->status->nama_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="tiket-meta">
                                    <span>
                                        <i class="lni lni-calendar"></i>
                                        {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }}
                                    </span>
                                    <span>
                                        <i class="lni lni-tag"></i>
                                        {{ $tiket->kategori->nama_kategori }}
                                    </span>
                                    <span>
                                        <i class="lni lni-bookmark"></i>
                                        {{ $tiket->event->nama_event }}
                                    </span>
                                    <span>
                                        @php
                                            $prioritasClass = 'badge-low';
                                            $prioritasName = strtolower($tiket->prioritas->nama_prioritas);
                                            if(str_contains($prioritasName, 'critical')) $prioritasClass = 'badge-critical';
                                            elseif(str_contains($prioritasName, 'high')) $prioritasClass = 'badge-high';
                                            elseif(str_contains($prioritasName, 'medium')) $prioritasClass = 'badge-medium';
                                        @endphp
                                        <span class="badge-prioritas {{ $prioritasClass }}">
                                            <i class="lni lni-flag"></i> {{ $tiket->prioritas->nama_prioritas }}
                                        </span>
                                    </span>
                                </div>

                                @if($tiket->deskripsi)
                                    <div class="mt-3">
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            {{ Str::limit($tiket->deskripsi, 150) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="lni lni-inbox" style="font-size: 5rem; color: #DFE1E6;"></i>
                    <h3 class="mt-4 text-muted">Belum Ada Tiket</h3>
                    <p class="text-muted">Anda belum memiliki tiket support. Buat tiket pertama Anda sekarang!</p>
                    <a href="{{ route('tiket.create') }}" class="btn btn-primary-custom mt-3">
                        <i class="lni lni-plus"></i> Buat Tiket Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
</body>
</html>

<style>
        :root {
            --primary: #0052CC;
            --secondary: #172B4D;
            --accent: #00B8D9;
            --success: #00875A;
            --warning: #FF991F;
            --danger: #DE350B;
        }
        body {
            background: #F4F5F7;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.5rem;
        }
        .main-container {
            padding: 40px 0;
            min-height: calc(100vh - 80px);
        }
        .page-header {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .page-header h1 {
            color: var(--secondary);
            font-weight: 700;
            margin-bottom: 10px;
        }
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
            transition: all 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .stats-card.open { border-color: var(--primary); }
        .stats-card.progress { border-color: var(--warning); }
        .stats-card.resolved { border-color: var(--success); }
        .stats-card.closed { border-color: #6B778C; }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .tiket-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #DFE1E6;
            transition: all 0.3s;
            cursor: pointer;
        }
        .tiket-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }
        .tiket-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        .tiket-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--primary);
            font-size: 0.95rem;
        }
        .tiket-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary);
            margin: 8px 0;
        }
        .tiket-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.875rem;
            color: #6B778C;
        }
        .tiket-meta i {
            margin-right: 5px;
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-open { background: #DEEBFF; color: #0052CC; }
        .badge-progress { background: #FFFAE6; color: #FF991F; }
        .badge-resolved { background: #E3FCEF; color: #00875A; }
        .badge-closed { background: #F4F5F7; color: #6B778C; }
        .badge-prioritas {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-critical { background: #FFEBE6; color: #DE350B; }
        .badge-high { background: #FFFAE6; color: #FF991F; }
        .badge-medium { background: #FFF7D6; color: #FF8B00; }
        .badge-low { background: #E3FCEF; color: #00875A; }
        .btn-primary-custom {
            background: var(--primary);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
        }
        .empty-state img {
            width: 200px;
            margin-bottom: 20px;
            opacity: 0.7;
        }
        .form-select, .form-control {
            border-radius: 8px;
            border: 2px solid #DFE1E6;
            padding: 10px 15px;
        }
        .form-select:focus, .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>