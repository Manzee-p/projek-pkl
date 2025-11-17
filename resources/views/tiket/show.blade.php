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

            <!-- Card Detail -->
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
                            <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}" target="_blank" 
                                class="btn btn-outline-primary btn-sm">
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
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                        </small>
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

            {{-- ========================= --}}
            {{-- SECTION: TOMBOL KOMENTAR --}}
            {{-- ========================= --}}

            @if($tiket->status->nama_status === 'Selesai')
                @if(!$tiket->hasUserComment(Auth::id()))
                    <div class="card border-0 shadow-sm mt-4" 
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center text-white mb-3 mb-md-0">
                                        <div class="me-3">
                                            <i class="lni lni-checkmark-circle" style="font-size: 3rem;"></i>
                                        </div>
                                        <div>
                                            <h4 class="fw-bold mb-2">Tiket Anda Telah Selesai! 🎉</h4>
                                            <p class="mb-0">Berikan komentar dan rating untuk membantu kami meningkatkan layanan.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <a href="{{ route('tiket.komentar.form', $tiket->tiket_id) }}" 
                                        class="btn btn-light btn-lg px-4">
                                        <i class="lni lni-comments me-2"></i> Berikan Komentar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-success border-0 mt-4 d-flex align-items-center">
                        <i class="lni lni-checkmark-circle fs-4 me-3"></i>
                        <div>
                            <strong>Terima Kasih!</strong> Anda sudah memberikan komentar untuk tiket ini.
                        </div>
                    </div>
                @endif
            @endif

            {{-- ========================= --}}
            {{-- SECTION: TAMPILKAN KOMENTAR --}}
            {{-- ========================= --}}

            @if($tiket->komentars && $tiket->komentars->count() > 0)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="lni lni-comments text-primary"></i> Komentar Anda
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($tiket->komentars->where('user_id', Auth::id()) as $komentar)
                            <div class="border-start border-4 ps-4 py-3
                                @if($komentar->tipe_komentar === 'feedback') border-primary bg-primary bg-opacity-10
                                @elseif($komentar->tipe_komentar === 'evaluasi') border-success bg-success bg-opacity-10
                                @else border-danger bg-danger bg-opacity-10
                                @endif">
                                
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge 
                                            @if($komentar->tipe_komentar === 'feedback') bg-primary
                                            @elseif($komentar->tipe_komentar === 'evaluasi') bg-success
                                            @else bg-danger
                                            @endif mb-2">
                                            @if($komentar->tipe_komentar === 'feedback')
                                                <i class="lni lni-thumbs-up"></i> Feedback
                                            @elseif($komentar->tipe_komentar === 'evaluasi')
                                                <i class="lni lni-bar-chart"></i> Evaluasi
                                            @else
                                                <i class="lni lni-warning"></i> Keluhan
                                            @endif
                                        </span>
                                        <p class="text-muted small mb-0">
                                            <i class="lni lni-calendar"></i> 
                                            {{ $komentar->waktu_komentar->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    <div class="text-end">
                                        <div class="mb-1" style="font-size: 1.5rem;">
                                            {{ str_repeat('⭐', $komentar->rating) }}
                                        </div>
                                        <small class="text-muted">
                                            @if($komentar->rating == 5) Sangat Puas
                                            @elseif($komentar->rating == 4) Puas
                                            @elseif($komentar->rating == 3) Cukup
                                            @elseif($komentar->rating == 2) Tidak Puas
                                            @else Sangat Tidak Puas
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <p class="mb-0 text-dark">{{ $komentar->komentar }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
</body>
</html>


{{-- ========================= --}}
{{--  STYLING  --}}
{{-- ========================= --}}

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
</style>
