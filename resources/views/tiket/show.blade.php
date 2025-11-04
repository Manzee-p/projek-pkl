<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket - {{ $tiket->judul }}</title>
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
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tiket.index') }}">
                            <i class="lni lni-arrow-left"></i> Kembali
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <div class="container">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="lni lni-ticket"></i> Detail Tiket</h1>
                        <p class="text-muted mb-0">Informasi lengkap tiket Anda</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm rounded-3 border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">{{ $tiket->judul }}</h4>

                    <div class="mb-3 text-muted">
                        <i class="lni lni-calendar"></i>
                        Dibuat: {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }}
                        <br>
                        <i class="lni lni-user"></i>
                        Oleh: {{ $tiket->user->name }}
                    </div>

                    <div class="mb-4">
                        @php
                            $statusClass = 'badge-open';
                            if($tiket->status->nama_status == 'In Progress') $statusClass = 'badge-progress';
                            elseif($tiket->status->nama_status == 'Resolved') $statusClass = 'badge-resolved';
                            elseif($tiket->status->nama_status == 'Closed') $statusClass = 'badge-closed';
                        @endphp
                        <span class="badge-status {{ $statusClass }}">
                            {{ $tiket->status->nama_status }}
                        </span>

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
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary">Kategori</h6>
                        <p>{{ $tiket->kategori->nama_kategori }}</p>

                        <h6 class="fw-bold text-secondary">Event Terkait</h6>
                        <p>{{ $tiket->event->nama_event }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary">Deskripsi</h6>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($tiket->deskripsi)) !!}
                        </div>
                    </div>

                    @if($tiket->lampiran)
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary">Lampiran</h6>
                            <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="lni lni-download"></i> Unduh Lampiran
                            </a>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary">Riwayat Status</h6>
                        @if($tiket->riwayat && $tiket->riwayat->count() > 0)
                            <ul class="list-group">
                                @foreach($tiket->riwayat as $log)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="lni lni-timer"></i> 
                                            {{ $log->status->nama_status }} 
                                            oleh {{ $log->user->name }}
                                        </span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Belum ada riwayat status.</p>
                        @endif
                    </div>

                    <div class="text-end">
                        <a href="{{ route('tiket.index') }}" class="btn btn-secondary">
                            <i class="lni lni-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
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
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
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
</style>
